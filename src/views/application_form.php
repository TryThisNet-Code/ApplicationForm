<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <input type="text" name="aName" placeholder="Enter your name">
    <input type="email" name="aEmail" placeholder="Enter your email">
    <input type="url" name="aLink" placeholder="Enter a link to your portfolio(Optional)">
    <textarea name="aLetter" placeholder="Type your cover letter"></textarea>
    <button onclick="sendApplication()">Submit Application</button>
    <div id="showSuccess">

    </div>
    <div id="applicationList">
        <?php foreach($applications as $appli): ?>
            <div class="applicants">
                <p>Name: <?= htmlspecialchars($appli['name'])?></p>
                <p>Email: <?= htmlspecialchars($appli['email'])?></p>
                <p>Portfolio: <?= htmlspecialchars($appli['portfolio'])?></p>
                <p>Cover Letter:<?= htmlspecialchars($appli['letter'])?></p>
                <small>Submitted at: <?= htmlspecialchars($appli['date'])?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function sendApplication(){
            const name = document.querySelector('input[name="aName"]').value;
            const email = document.querySelector('input[name="aEmail"]').value;
            const portfolio = document.querySelector('input[name="aLink"]').value;
            const letter = document.querySelector('textarea[name="aLetter"]').value;
            const feedback = document.getElementById("showSuccess");

            if(!name || !email || !letter){
                alert("Please fill all the field");
                return;
            }

            if(!validateEmail(email)){
                alert("Invalid email");
                return;
            }

            fetch("", {
                method: "POST",
                headers: {"Content-Type":"application/json"},
                body: JSON.stringify({name, email, portfolio, letter})
            })
            .then(res => res.json())
            .then(data => {
                feedback.innerText = Array.isArray(data.message) ? data.message.join('\\n') : data.message;
                feedback.style.color = data.success ? "green" : "red";

                if(data.success){
                    document.querySelector('input[name="aName"]').value = "";
                    document.querySelector('input[name="aEmail"]').value = "";
                    document.querySelector('input[name="aLink"]').value = "";
                    document.querySelector('textarea[name="aLetter"]').value = "";

                    const newAppEntry = document.createElement("div");
                    newAppEntry.classList.add("applicants");
                    newAppEntry.innerHTML = `
                        <p>Name: ${data.applicationEntry.name}</p>
                        <p>Email: ${data.applicationEntry.email}</p>
                        <p>Portfolio ${data.applicationEntry.portfolio}</p>
                        <p>Cover Letter: ${data.applicationEntry.letter}</p>
                        <small>Submitted at: ${data.applicationEntry.date}</small>
                    `;
                    document.getElementById("applicationList").prepend(newAppEntry);
                }
            })
        }

        function validateEmail(email){
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    </script>
</body>
</html>