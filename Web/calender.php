<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function () {
            $('#start_date').datepicker({
                defaultDate: '+1w',
                changeMonth: true,
                numberOfMonths: 1,
            });
        });
    </script>