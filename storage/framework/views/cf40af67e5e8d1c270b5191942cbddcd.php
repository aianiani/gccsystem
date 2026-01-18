<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Confirmation - <?php echo e($appointment->reference_number); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 3px solid #237728;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }
        .header .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #237728;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }
        .reference-number {
            background: #eaf5ea;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin: 15px 0;
            font-size: 14px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            color: #237728;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e0e0e0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-table td:first-child {
            font-weight: bold;
            color: #6c757d;
            width: 200px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-warning {
            background: #ffc107;
            color: #222;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1>CMU Guidance and Counseling Center</h1>
        </div>
        <div class="reference-number">
            Appointment Reference Number: <?php echo e($appointment->reference_number); ?>

        </div>
        <div style="text-align: center; color: #666;">
            <strong>Appointment Confirmation</strong><br>
            Generated on: <?php echo e(now()->format('F d, Y h:i A')); ?>

        </div>
    </div>

    <div class="section">
        <div class="section-title">Appointment Details</div>
        <table class="info-table">
            <tr>
                <td>Date & Time:</td>
                <td><?php echo e($appointment->scheduled_at->format('F d, Y h:i A')); ?></td>
            </tr>
            <tr>
                <td>Counselor:</td>
                <td><?php echo e($appointment->counselor->name); ?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><span class="badge badge-warning"><?php echo e(ucfirst($appointment->status)); ?></span></td>
            </tr>
            <?php if($appointment->notes): ?>
            <tr>
                <td>Notes:</td>
                <td><?php echo e($appointment->notes); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Nature of Problem</div>
        <table class="info-table">
            <tr>
                <td>Category:</td>
                <td><?php echo e($appointment->nature_of_problem); ?></td>
            </tr>
            <?php if($appointment->nature_of_problem === 'Other' && $appointment->nature_of_problem_other): ?>
            <tr>
                <td>Details:</td>
                <td><?php echo e($appointment->nature_of_problem_other); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Guardian Information</div>
        <table class="info-table">
            <tr>
                <td>Guardian 1 Name:</td>
                <td><?php echo e($appointment->guardian1_name); ?></td>
            </tr>
            <tr>
                <td>Guardian 1 Relationship:</td>
                <td><?php echo e($appointment->guardian1_relationship); ?></td>
            </tr>
            <tr>
                <td>Guardian 1 Contact:</td>
                <td><?php echo e($appointment->guardian1_contact); ?></td>
            </tr>
            <?php if($appointment->guardian2_name): ?>
            <tr>
                <td>Guardian 2 Name:</td>
                <td><?php echo e($appointment->guardian2_name); ?></td>
            </tr>
            <tr>
                <td>Guardian 2 Relationship:</td>
                <td><?php echo e($appointment->guardian2_relationship); ?></td>
            </tr>
            <tr>
                <td>Guardian 2 Contact:</td>
                <td><?php echo e($appointment->guardian2_contact); ?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Student Information</div>
        <table class="info-table">
            <tr>
                <td>Full Name:</td>
                <td><?php echo e($appointment->student->name); ?></td>
            </tr>
            <tr>
                <td>College:</td>
                <td><?php echo e($appointment->student->college ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Course:</td>
                <td><?php echo e($appointment->student->course ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Year Level:</td>
                <td><?php echo e($appointment->student->year_level ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Sex:</td>
                <td><?php echo e(ucfirst($appointment->student->gender ?? 'N/A')); ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php echo e($appointment->student->address ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Contact Number:</td>
                <td><?php echo e($appointment->student->contact_number ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td>Email Address:</td>
                <td><?php echo e($appointment->student->email); ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">DASS-42 Assessment</div>
        <table class="info-table">
            <tr>
                <td>Assessment Status:</td>
                <td>Completed - Submitted for counselor review</td>
            </tr>
            <?php if($dass42Assessment): ?>
            <tr>
                <td>Assessment Date:</td>
                <td><?php echo e($dass42Assessment->created_at->format('F d, Y')); ?></td>
            </tr>
            <?php endif; ?>
        </table>
        <p style="font-size: 10px; color: #888; margin-top: 10px; font-style: italic; padding: 8px; background: #f8f9fa; border-left: 3px solid #237728;">
            <strong>Confidentiality Notice:</strong> Assessment scores are confidential and are only accessible to your assigned counselor. Your counselor will review your assessment results and discuss them with you during your counseling session.
        </p>
    </div>

    <div class="footer">
        <p><strong>CMU Guidance and Counseling Center</strong></p>
        <p>This is a system-generated confirmation. Please keep this document for your records.</p>
        <p>If you have any questions or need to reschedule, please contact the guidance office.</p>
    </div>
</body>
</html>

<?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/appointments/confirmation-pdf.blade.php ENDPATH**/ ?>