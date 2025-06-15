<div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">Welcome to EduFun</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <?php
                        $query = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_id = '$session_id'") or die(mysqli_error());
                        $row = mysqli_fetch_array($query);
                        
                        // Check if teacher data exists
                        if($row) {
                            $teacher_name = $row['firstname']." ".$row['lastname'];
                        } else {
                            $teacher_name = "Unknown Teacher";
                        }
                    ?>
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user icon-large"></i>
                            <span id="greeting" class="greeting-text"></span>
                            <?php echo $teacher_name; ?>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="change_password_teacher.php"><i class="icon-circle"></i> Change Password</a>
                                <a tabindex="-1" href="#myModal" data-toggle="modal"><i class="icon-picture"></i> Change Avatar</a>
                                <a tabindex="-1" href="profile_teacher.php"><i class="icon-user"></i> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="logout.php"><i class="icon-signout"></i>&nbsp;Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include('avatar_modal.php'); ?>

<style>
    .greeting-text {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
        display: inline-block;
        margin-right: 5px;
    }
    .fade-out {
        opacity: 0;
    }
</style>

<script>
    const greetings = [
        "Halo", "Hello", "Bonjour", "Hola", "Ciao", "Hallo",
        "こんにちは", "안녕하세요", "你好", "Привет",
        "Salam", "Hei", "Olá", "नमस्ते", "Sawubona"
    ];

    let index = 0;
    const greetingElement = document.getElementById("greeting");

    function changeGreeting() {
        greetingElement.classList.add("fade-out");
        setTimeout(() => {
            greetingElement.textContent = greetings[index] + ", ";
            greetingElement.classList.remove("fade-out");
            index = (index + 1) % greetings.length;
        }, 500);
    }

    changeGreeting();
    setInterval(changeGreeting, 3000);
</script>