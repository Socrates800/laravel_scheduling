<!DOCTYPE html>
<html>
<head>
    <title>Database Backup Notification</title>
</head>
<body>
    <h2>{{ $success ? '✅ Backup Successful' : '❌ Backup Failed' }}</h2>

    @if ($success)
        <p>The database was backed up successfully at {{ now()->format('d M Y, h:i A') }}.</p>
        <p><strong>File:</strong> {{ $fileName }}</p>
    @else
        <p>There was an error during the backup process:</p>
        <pre>{{ $errorMessage }}</pre>
    @endif

    <p>-- Laravel Automation Bot</p>
</body>
</html>
