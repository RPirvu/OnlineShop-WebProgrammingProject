<?php include 'includes/session.php'; ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>AL&ICA</title>
    </head>
    <body>
        <div class = "content">
            <div class = "container">
                <div class = "col-md-12">
                    <h1>Contactează-ne</h1><!--partea de body-->
                </div>
            </div>
			
            <div class="container">
            <div class="col-md-12">
            <hr>
            </div>
            </div>
            
            <div class="container">
                <div class="col-md-6 contacts">
                    <h1><span class="glyphicon glyphicon-user"></span> Mihoc Alexandru & Robert Parvu</h1>
                    <p>
                        <span class="glyphicon glyphicon-envelope"></span> Email: <br>
                        <span class="glyphicon glyphicon-link"></span> Facebook:<br>
                        <span class="glyphicon glyphicon-phone"></span> Mobile: 
                    </p>
                </div>
                <div class="col-md-6">
                <form action="contactform.php" method="POST">
                    <div class="form-group">
                        <label for="name">Nume:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                    <p class="usertext">
                        <label for="text">Mesaj:</label>
                        <textarea class="form-control" name="text"></textarea>
                    </p>
                    </div>
                    <div class="form-group">
                        <p class="usersubmit">
                        <button class="btn btn-success" name="submit" value ="Send" type="submit">Trimite</button>
                    </p>
                    </div>
                </form>
    </div>
</div>			            
</div><!--partea de body-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"
        type="text/javascript"></script>
    <script type="text/javascript">
        function validateContactForm() {
            var valid = true;

            $(".info").html("");
            $(".input-field").css('border', '#e0dfdf 1px solid');
            var userName = $("#userName").val();
            var userEmail = $("#userEmail").val();
            var subject = $("#subject").val();
            var content = $("#content").val();
            
            if (userName == "") {
                $("#userName-info").html("Required.");
                $("#userName").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (userEmail == "") {
                $("#userEmail-info").html("Required.");
                $("#userEmail").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (!userEmail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
            {
                $("#userEmail-info").html("Invalid Email Address.");
                $("#userEmail").css('border', '#e66262 1px solid');
                valid = false;
            }

            if (subject == "") {
                $("#subject-info").html("Required.");
                $("#subject").css('border', '#e66262 1px solid');
                valid = false;
            }
            if (content == "") {
                $("#userMessage-info").html("Required.");
                $("#content").css('border', '#e66262 1px solid');
                valid = false;
            }
            return valid;
        }
</script>
</body>
    </body>

