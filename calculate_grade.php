<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Grade Calcuation Results</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
        <h1>Grade Calculation Results</h1>
        <div class="title-separator"></div>

        <?php 
        // We're using arrays to store points
        $all_earned_points = [];
        $all_possible_points = [];
        $assignment_results = [];

        // Loop through the assignments to pull and check data
        for ($i = 1; $i <= 6; $i++) {
            $earned_name = 'grade' . $i . '_earned';
            $possible_name = 'grade' . $i . '_possible';

            // This is our check for empty fields
            if (isset($_POST[$earned_name]) && isset($_POST[$possible_name]) &&
                $_POST[$earned_name] !== '' && $_POST[$possible_name] !== '') {
                
                // This turns our string inputs into floating point numbers
                $earned = floatval($_POST[$earned_name]);
                $possible = floatval($_POST[$possible_name]);

                // Another check for zero points possible handling
                if ($possible > 0) {
                    $assignment_percentage = ($earned / $possible) * 100;
                    $assignment_results[$i] = [
                        'earned' => $earned,
                        'possible' => $possible,
                        'percentage' => $assignment_percentage 
                    ];
                                
                    // Now we add to the overall totals
                    $all_earned_points[] = $earned;
                    $all_possible_points[] = $possible;
                } else { 
                    // Handling for possible zero points
                    $assignment_results[$i] = [
                        'earned' => $earned, 
                        'possible' => $possible,
                        'percentage' => 'N/A (Points Possible was zero)'
                    ];
                }

            } else {
                // This handles missing or empty fields
                $assignment_results[$i] = [
                    'earned' => 'N/A',
                    'possible' => 'N/A',
                    'percentage' => 'N/A (Missing or Empty)'
                ];
            }
        }

        // Now we calculate the overall grade from valid assignment points
        $total_earned_overall = array_sum($all_earned_points);
        $total_possible_overall = array_sum($all_possible_points);

        // This starts us at 0 and will calculate the overall percentage only if possible points greater tha zero.
        $overall_percentage = 0;
        if ($total_possible_overall > 0) {
            $overall_percentage = ($total_earned_overall / $total_possible_overall) * 100;
        } else {
            // If no valid assignments or points are zero, set overall percentage to N/A
            $overall_percentage = 'N/A (No valid assignments or total possible points was zero)';
        }

        if (is_numeric($overall_percentage)) {
            if ($overall_percentage >= 90) {
                $letter_grade = 'A';
                $grade_color_class = 'grade-a';
            } elseif ($overall_percentage >= 80) {
                $letter_grade = 'B';
                $grade_color_class = 'grade-b';
            } elseif ($overall_percentage >= 70) {
                $letter_grade = 'C';
                $grade_color_class = 'grade-c';
            } elseif ($overall_percentage >= 60) {
                $letter_grade = 'D';
                $grade_color_class = 'grade-d';
            } else {
                $letter_grade = 'F';
                $grade_color_class = 'grade-f';
            }
        } else {
            $letter_grade = 'N/A';
            $grade_color_class = 'grade-na';
        }

        ?> 

        <h1>Assignment Details</h1>
        <?php foreach ($assignment_results as $num => $result): ?>
            <div class="assignment-grade">
                <h3>Assignment <?php echo $num; ?></h3>
                <p>Points Earned: <?php echo htmlspecialchars($result['earned']); ?></p>
                <p>Points Possible: <?php echo htmlspecialchars($result['possible']); ?></p>
                <p>Percentage: <?php echo is_numeric($result['percentage']) ? number_format($result['percentage'], 2) . '%' : htmlspecialchars($result['percentage']); ?></p>
            </div>
        <?php endforeach; ?>

        <div class="overall-grade <?php echo $grade_color_class; ?>">
            <h2>Overall Grade</h2>
            <p>Total Points Earned: <?php echo htmlspecialchars($total_earned_overall); ?></p> 
            <p>Total Points Possible: <?php echo htmlspecialchars($total_possible_overall); ?></p>
            <p>Overall Percentage: <?php echo is_numeric($overall_percentage) ? number_format($overall_percentage, 2) . '%' : htmlspecialchars($overall_percentage); ?></p>
                <?php if (is_numeric($overall_percentage)): ?>
                    <p class="letter-grade-display">Letter Grade: <span><?php echo $letter_grade; ?></span></p>
                <?php endif; ?>
        </div>
    </div>

    <div class="footer-content">
        <p>Created by Nicole Christianna</p>
        <a href="index.html" class="restart-button"> Restart Quackulator</a>
    </div>
</body>
</html>
