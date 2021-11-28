<?php

  // Set the timezone
  date_default_timezone_set("EET");

  // Get prev & next month
  if (isset($_GET['m'])
  ) {
      $ym = $_GET['m'];

  } else {
        // This month
      $ym = date('Y-m');
  }

  if (isset($_GET['today'])
  ) {
      $ym = date('Y-m');
  }
   
  $timestamp = strtotime($ym . '-01'); // The first day of the month.
  if ($timestamp === false) {
      $ym = date('Y-m');
      $timestamp = strtotime($ym . '-01');
  }
    // Today 
  $today = date('Y-m-j', time());

    // Title.(Format:November, 2021)
  $html_title = date('F , Y', $timestamp);

    // Create prev and next month link
  $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
  $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

    // Number of days in the month
  $day_count = date('t', $timestamp);

    // The days of the week.
  $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

    // Array for calendar
  $weeks = array();
  $week = '';

  // Add empty cells
  $week .= str_repeat('<td></td>', $str);

  for ( $day = 1; $day <= $day_count; $day++, $str++) {
      
      $date = $ym . '-' . $day;
      
      if ($today == $date) {
          $week .= '<td class="today">' . $day;
      } else {
          $week .= '<td>' . $day;
      }
      $week .= '</td>';


      // Sunday Or last day of the month.
      if ($str % 7 == 6 || $day == $day_count) {

      // Last day of the month
          if ($day == $day_count) {
            // Add empty cell(s)
              $week .= str_repeat('<td></td>', 6 - ($str % 7));
          }

          $weeks[] = '<tr>' . $week . '</tr>';

          $week = '';
      }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Calendar</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Calendar</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
          <form class="row g-3" action="index.php" method="POST">
            <div class="col-md-6 col-lg-6">
              <label class="form-label" for="month">Select month</label>
              <select name="m" class="form-control" id="month">
                <option  value="1">January</option>
                <option  value="2">February</option>
                <option  value="3">March</option>
                <option  value="4">April</option>
                <option  value="5">May</option>
                <option  value="6">June</option>
                <option  value="7">July</option>
                <option  value="8">August</option>
                <option  value="9">September</option>
                <option  value="10">October</option>
                <option  value="11">November</option>
                <option  value="12">December</option>
              </select>
            </div>
            <div class="col-md-6 col-lg-6">
              <label class="form-label" for="year">Year:</label>
              <input type="text" name="y" class="form-control" value="2021">
            </div>
            <div class="col-md-12 col-lg-12">
              <button type="submit" class="btn btn-primary">Show</button>
              <a href="?today=<?php echo $ym; ?>" class="btn btn-secondary">Today</a>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mt-5 offset-md-3 col-lg-6 offset-lg-3">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>
                  <a href="?m=<?php echo $prev; ?>" title="Previous month">&larr;</a>
                </th>
                <th colspan="5" class="text-center"><?php echo $html_title; ?></th>
                <th>
                  <a href="?m=<?php echo $next; ?>" title="Next month">&rarr;</a>
                </th>
              <tr>               
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
              </tr>
            </thead>
            <tbody>
                <?php

                // print the calendar
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>