<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
include "connecttodatabaseinfo.php";
include "navBar.php";

if (isset($_GET['searchBox'])) {
    $_SESSION['courses_searchBox'] = $_GET['searchBox'];
}

$searchBox = $_SESSION['courses_searchBox'] ?? '';
?>

<h1 class="text-center my-4">Courses</h1>

<div class="container">
    <form class="d-flex mb-4" method="GET" action="">
        <input class="form-control" type="text" name="searchBox" placeholder="Search courses" value="<?= $searchBox ?>">
        <button class="btn btn-success ms-2" type="submit">Search</button>
    </form>
</div>
<br>

<div class="container">
    <div class="table-responsive">
    <?php
    $mysqli = connectToDatabase();
    $sql = "SELECT * FROM app_events";
    if ($searchBox) {
        $sql .= " WHERE Course LIKE '%" . $mysqli->real_escape_string($searchBox) . "%'";
    }

    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Course Name</th>
                    <th scope="col">Information</th>
                    <th scope="col">Time</th>
                    <th scope="col">Room</th>
                    <th scope="col">Add to Timetable</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($event = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $event['Course']?></td>
                    <td><?= $event['Information'] ?></td>
                    <td><?= $event['Time'] ?></td>
                    <td><?= $event['Room_Number'] ?></td>
                    <td>
                        <button class="btn btn-primary add-to-timetable" data-event='<?= json_encode($event) ?>'>Add</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No events found in the database.</p>
    <?php endif;
    $mysqli->close();
    ?>
    </div>
</div>

<div class="modal fade" id="timetableModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Timetable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="timetableContent">
                <p>Your timetable will be displayed here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let timetable = [];
document.querySelectorAll('.add-to-timetable').forEach(button => {
    button.addEventListener('click', function () {
        const event = JSON.parse(this.getAttribute('data-event'));
        timetable.push(event);
        alert(`${event.Course} added to your timetable.`);
        displayTimetable();
    });
});

function displayTimetable() {
    const timetableContent = document.getElementById('timetableContent');
    timetableContent.innerHTML = "";
    if (timetable.length > 0) {
        timetable.forEach((event, index) => {
            timetableContent.innerHTML += `
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">${event.Information}</h5>
                        <p><strong>Course:</strong> ${event.Course}</p>
                        <p><strong>Time:</strong> ${event.Time}</p>
                        <p><strong>Room:</strong> ${event.Room_Number}</p>
                        <button class="btn btn-danger" onclick="removeFromTimetable(${index})">Remove</button>
                    </div>
                </div>`;
        });
    } else {
        timetableContent.innerHTML = "<p>No events added to your timetable.</p>";
    }
}

function removeFromTimetable(index) {
    timetable.splice(index, 1);
    displayTimetable();
}

const timetableModal = new bootstrap.Modal(document.getElementById('timetableModal'));
document.getElementById('timetableModal').addEventListener('shown.bs.modal', displayTimetable);
</script>
</body>
</html>