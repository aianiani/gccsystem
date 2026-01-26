<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Analytics Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #1f7a2d;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 10pt;
            font-weight: bold;
        }

        .section-header {
            background-color: #1f7a2d;
            color: white;
            padding: 6px 10px;
            font-weight: bold;
            margin-top: 15px;
            border: 1px solid #1f7a2d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e8f5e8;
            color: #1f7a2d;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .kpi-box {
            width: 24%;
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            margin-right: 1%;
            margin-bottom: 15px;
        }

        .kpi-box h3 {
            margin: 0;
            font-size: 18pt;
            color: #1f7a2d;
        }

        .kpi-box p {
            margin: 5px 0 0;
            font-size: 8pt;
            text-transform: uppercase;
            color: #666;
        }

        .row {
            width: 100%;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Analytics Overview Report</h1>
        <p><?php echo e($startDate->format('F d, Y')); ?> - <?php echo e($endDate->format('F d, Y')); ?></p>
        <p style="font-size: 8pt; font-weight: normal; margin-top: 2px;">GCC System Generated Report</p>
    </div>

    <!-- KPIs -->
    <div class="row">
        <div class="kpi-box">
            <h3><?php echo e(number_format($totalAppointments)); ?></h3>
            <p>Total Sessions</p>
        </div>
        <div class="kpi-box">
            <h3><?php echo e(number_format($avgWaitTime, 1)); ?></h3>
            <p>Avg Wait (Days)</p>
        </div>
        <div class="kpi-box">
            <h3><?php echo e(number_format($cancellationRate, 1)); ?>%</h3>
            <p>Cancellation Rate</p>
        </div>
        <div class="kpi-box" style="margin-right: 0;">
            <h3><?php echo e(number_format($criticalRiskCount)); ?></h3>
            <p>Critical Risks</p>
        </div>
    </div>

    <!-- Section 1: Appointment & Counseling Stats -->
    <div class="section-header">A. APPOINTMENT STATISTICS</div>
    <table>
        <thead>
            <tr>
                <th width="50%">Appointment Status</th>
                <th width="50%">Count</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $appointmentStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-left"><?php echo e(ucfirst($status)); ?></td>
                    <td><?php echo e($count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Nature of Problem -->
    <div class="section-header">B. TOP PRESENTING PROBLEMS</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Problem Nature</th>
                <th width="30%">Count</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $problemDistribution->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $problem => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-left"><?php echo e($problem); ?></td>
                    <td><?php echo e($count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="2">No data recorded.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Risk Distribution -->
    <div class="section-header">C. RISK PROFILE (Assessment)</div>
    <table>
        <thead>
            <tr>
                <th width="50%">Risk Level</th>
                <th width="50%">Students Count</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $riskDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risk => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-left"><?php echo e(ucfirst($risk)); ?></td>
                    <td><?php echo e($count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="2">No assessments recorded.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Seminar Reach -->
    <div class="section-header">D. SEMINAR OUTREACH</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Seminar Name</th>
                <th width="30%">Attendees</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $seminarAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-left"><?php echo e($name); ?></td>
                    <td><?php echo e($count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="2">No seminar records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; color: #999;">
        Generated by <?php echo e(auth()->user()->name); ?> on <?php echo e(now()->format('Y-m-d H:i')); ?>

    </div>
</body>

</html><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/admin/analytics/export_pdf.blade.php ENDPATH**/ ?>