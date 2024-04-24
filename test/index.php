<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordinal Numbers Example</title>
</head>
<body>
    <h1>Ordinal Numbers from 1 to 20</h1>
    <ul>
        <?php
        function numberToOrdinal($number) {
            // Assure that the number is a positive integer
            $number = intval($number);

            // Select the appropriate suffix based on the last digit
            $lastDigit = $number % 10;
            $lastTwoDigits = $number % 100;

            if (in_array($lastTwoDigits, [11, 12, 13])) {
                $suffix = 'th';
            } else {
                switch ($lastDigit) {
                    case 1:
                        $suffix = 'st';
                        break;
                    case 2:
                        $suffix = 'nd';
                        break;
                    case 3:
                        $suffix = 'rd';
                        break;
                    default:
                        $suffix = 'th';
                        break;
                }
            }

            // Return the number with the appropriate suffix
            return $number . $suffix;
        }

        // Display numbers from 1 to 20 as ordinal numbers in an HTML list
        for ($i = 1; $i <= 200; $i++) {
            echo "<li>" . numberToOrdinal($i) . "</li>";
        }
        ?>
    </ul>
</body>
</html>
