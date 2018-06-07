<html>
    <head>
        <style>
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
            }        
        </style>
        <script type="application/javascript">
            function updateStatics(stats){
                document.getElementById("statusreport").innerHTML = stats;
            }
        </script>
    </head>
    <body>
        <table id="customers" width="200px">
            <tr>
                <td>Processing Record</td>
                <td><span id="statusreport"></span></td>
            </tr>
    </body>
</html>
