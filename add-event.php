<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add an Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <?php include "staff-navBar.php"; ?>
<!-- Add an event form -->
    <form method="POST" action="insert-event.php">
        <div class="container">
            <h1 class="text-center">Add a New Event</h1>
            <p class="text-center">Fill in the details below to schedule a new event.</p>

            <label for="course"><b>Enter the Course</b></label>
            <input type="text" name="Course" required>

            <label for="time"><b>Time</b></label>
            <input type="time" name="Time" required>
            
            <br>
            
            <label for="information"><b>Enter the Details Related to This Event</b></label>
            <input type="text" name="Information" required>

            <label for="room"><b>Room Number</b></label>
            <input type="text" name="Room_Number" required>

            <div class="clearfix mt-3">
                <button type="button" class="btn btn-danger" onclick="window.location.href='staff-homePage.php'">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
