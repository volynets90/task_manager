<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/js-datepicker/dist/datepicker.min.css">
</head>

<body>

    <div class="container ">
        <form class="col-5 ms-auto me-auto mb-5 mt-5" name="taskForm">
            <div class="mb-3 col-10">
                <label for="fio" class="form-label"><b> Name</b></label>
                <input type="text" class="form-control" id="fio" name="fio">
            </div>
            <div class="mb-3  col-10">
                <label for="email" class="form-label"><b> Email address</b></label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3  col-8">
                <label for="endDate" class="form-label"><b> End date</b></label>
                <input type="text" class="form-control" id="endDate" name="endDate">
            </div>
            <div class="mb-3  col-10">
                <label for="taskName" class="form-label"><b> Task name</b></label>
                <input type="text" class="form-control" id="taskName" name="taskName">
            </div>
            <div class="mb-3  col-10">
                <label for="taskDescription" class="form-label"><b> Task description</b></label>
                <textarea class="form-control" id="taskDescription" rows="3" name="taskDescription"></textarea>
            </div>
            <p id="error" class="text-danger"></p>
            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </form>
        <div class="mb-3  col-5">
            <label for="search" class="form-label"><b>Search by name</b></label>
            <input type="text" class="form-control" id="searchByName" name="search">
        </div>
        <div class="mb-3  col-5">
            <label for="search" class="form-label"><b>Search by task name</b></label>
            <input type="text" class="form-control" id="searchByTaskName" name="search">
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Task name</th>
                    <th scope="col" style="cursor:pointer;" onclick="sortByDate(2);">Date of creation</th>
                    <th scope="col" id="endDateHeader" style="cursor:pointer;" onclick="sortByDate(3);">End date of
                        tasks
                    </th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id='tasksTable'>
            </tbody>
        </table>

    </div>

    <script src="/js/bootstrap.min.js"></script>
    <script src="node_modules/js-datepicker/dist/datepicker.min.js"></script>
    <script src="node_modules/inputmask/dist/inputmask.min.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>