<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$q = trim((string)($_GET['q'] ?? ''));
$statusFilter = trim((string)($_GET['status'] ?? ''));

$pageNo = (int)($_GET['page'] ?? 1);
if ($pageNo <= 0) {
    $pageNo = 1;
}
$perPage = 20;
$offset = ($pageNo - 1) * $perPage;
if ($offset < 0) {
    $offset = 0;
}

$where = [];
$params = [];

if ($statusFilter !== '') {
    $where[] = 'p.status = :status';
    $params[':status'] = $statusFilter;
}

if ($q !== '') {
    $where[] = '(p.reference LIKE :q_ref OR CAST(p.id AS CHAR) LIKE :q_id OR CAST(p.booking_id AS CHAR) LIKE :q_bid)';
    $params[':q_ref'] = '%' . $q . '%';
    $params[':q_id'] = '%' . $q . '%';
    $params[':q_bid'] = '%' . $q . '%';
}

$whereSql = $where ? (' WHERE ' . implode(' AND ', $where)) : '';

$total = 0;
try {
    $stmtCount = db()->prepare('SELECT COUNT(*) AS c FROM payments p' . $whereSql);
    $stmtCount->execute($params);
    $total = (int)($stmtCount->fetch()['c'] ?? 0);
} catch (Throwable $e) {
    $total = 0;
}

$rows = [];
try {
    $sql = "SELECT p.*, b.customer_name, b.phone
            FROM payments p
            LEFT JOIN bookings b ON b.id = p.booking_id"
        . $whereSql
        . ' ORDER BY p.id DESC LIMIT :limit OFFSET :offset';

    $stmt = db()->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();
} catch (Throwable $e) {
    $rows = [];
}

$totalPages = (int)max(1, (int)ceil($total / $perPage));
if ($pageNo > $totalPages) {
    $pageNo = $totalPages;
}

$qsBase = [];
if ($q !== '') {
    $qsBase['q'] = $q;
}
if ($statusFilter !== '') {
    $qsBase['status'] = $statusFilter;
}

include __DIR__ . '/partials/header.php';

function money_fmt(float $n): string
{
    return number_format($n, 2);
}

?>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h1 class="h4 fw-bold m-0">المدفوعات</h1>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="get" id="paymentsFilterForm" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label">بحث (Reference / Payment ID / Booking ID)</label>
                <input class="form-control" name="q" value="<?= e($q) ?>" placeholder="مثال: INV أو رقم">
            </div>
            <div class="col-md-3">
                <label class="form-label">الحالة</label>
                <select class="form-select" name="status">
                    <option value="" <?= $statusFilter === '' ? 'selected' : '' ?>>الكل</option>
                    <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>pending</option>
                    <option value="paid" <?= $statusFilter === 'paid' ? 'selected' : '' ?>>paid</option>
                    <option value="failed" <?= $statusFilter === 'failed' ? 'selected' : '' ?>>failed</option>
                    <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>cancelled</option>
                    <option value="refunded" <?= $statusFilter === 'refunded' ? 'selected' : '' ?>>refunded</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">تطبيق</button>
                <a class="btn btn-outline-secondary" href="payments.php">مسح</a>
            </div>
        </form>
        <div class="text-secondary small mt-2">النتائج: <?= (int)$total ?></div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Booking</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                    <tr>
                        <td colspan="9" class="text-secondary">
                            <div class="py-4">
                                <div class="fw-bold mb-1">لا توجد مدفوعات بعد</div>
                                <div class="small mb-3">لن يظهر شيء هنا إلا بعد إنشاء رابط دفع من فاتورة الحجز (بعد تأكيد الإدارة).</div>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a class="btn btn-outline-primary btn-sm" href="bookings.php">الذهاب إلى الحجوزات</a>
                                    <a class="btn btn-outline-secondary btn-sm" href="payments.php">تحديث</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= (int)($r['booking_id'] ?? 0) ?></td>
                        <td>
                            <?= e((string)($r['customer_name'] ?? '')) ?>
                            <div class="text-secondary small" dir="ltr"><?= e((string)($r['phone'] ?? '')) ?></div>
                        </td>
                        <td class="fw-semibold"><?= e(money_fmt((float)($r['amount'] ?? 0))) ?></td>
                        <td><?= e((string)($r['currency'] ?? 'ILS')) ?></td>
                        <td><span class="badge text-bg-secondary"><?= e((string)($r['status'] ?? '')) ?></span></td>
                        <td><?= e((string)($r['method'] ?? '')) ?></td>
                        <td dir="ltr" class="small"><?= e((string)($r['reference'] ?? '')) ?></td>
                        <td class="text-end">
                            <a class="btn btn-outline-secondary btn-sm" href="../pay.php?ref=<?= e((string)($r['reference'] ?? '')) ?>" target="_blank">فتح</a>
                            <?php if ((int)($r['booking_id'] ?? 0) > 0): ?>
                                <a class="btn btn-outline-primary btn-sm" href="booking_invoice.php?id=<?= (int)$r['booking_id'] ?>" target="_blank">فاتورة</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($totalPages > 1): ?>
    <nav class="mt-3" aria-label="Pagination">
        <ul class="pagination mb-0 flex-wrap">
            <?php
            $mk = static function (int $p) use ($qsBase): string {
                $qs = $qsBase;
                $qs['page'] = $p;
                return 'payments.php?' . http_build_query($qs);
            };
            $prev = max(1, $pageNo - 1);
            $next = min($totalPages, $pageNo + 1);
            ?>
            <li class="page-item <?= $pageNo <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($mk($prev)) ?>">Previous</a>
            </li>

            <?php
            $start = max(1, $pageNo - 2);
            $end = min($totalPages, $pageNo + 2);
            if ($start > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . e($mk(1)) . '">1</a></li>';
                if ($start > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
            }
            for ($p = $start; $p <= $end; $p++) {
                $active = $p === $pageNo ? 'active' : '';
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . e($mk($p)) . '">' . (int)$p . '</a></li>';
            }
            if ($end < $totalPages) {
                if ($end < $totalPages - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="' . e($mk($totalPages)) . '">' . (int)$totalPages . '</a></li>';
            }
            ?>

            <li class="page-item <?= $pageNo >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= e($mk($next)) ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<script>
    (function () {
        var form = document.getElementById('paymentsFilterForm');
        if (!form) return;
        var q = form.querySelector('input[name="q"]');
        var s = form.querySelector('select[name="status"]');
        var t = null;

        function submit() {
            try {
                form.submit();
            } catch (e) {
            }
        }

        if (q) {
            q.addEventListener('input', function () {
                if (t) clearTimeout(t);
                t = setTimeout(submit, 350);
            });
        }
        if (s) s.addEventListener('change', submit);
    })();
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
