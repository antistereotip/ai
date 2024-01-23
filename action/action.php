<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Kontakt forma</title>
</head>
<body>


<?php

$errors = [];
$errorMessage = '';

if (!empty($_POST)) {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $message = $_POST['message'];

   if (empty($name)) {
       $errors[] = 'Name is empty';
   }

   if (empty($email)) {
       $errors[] = 'Email is empty';
   } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $errors[] = 'Email is invalid';
   }

   if (empty($message)) {
       $errors[] = 'Message is empty';
   }

   if (empty($errors)) {
       $toEmail = 'milutingavrilovic@gmail.com';
       $emailSubject = 'Novi mail iz vase kontakt forme';
       $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=utf-8'];
       $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Message:", $message];
       $body = join(PHP_EOL, $bodyParagraphs);

       if (mail($toEmail, $emailSubject, $body, $headers)) {

           header('Location: thank-you.html');
       } else {
           $errorMessage = 'Oops, nesto je krenulo naopako. Molimo pokusajte kasnije';
       }

   } else {

       $allErrors = join('<br/>', $errors);
       $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
   }
}

?>
<html>
<body>
 <form  method="post" id="contact-form">
   <h2>Kontaktirajte nas samo osnovnim podacima i javicemo Vam se u roku od 12 sati.</h2>
   <h3>Neophodno je da u polje message ili poruke napisete detaljno sta Vam i koliko treba.</h3>
   <?php echo((!empty($errorMessage)) ? $errorMessage : '') ?>
   <p>
     <label>First Name:</label>
     <input name="name" type="text"/>
   </p>
   <p>
     <label>Email Address:</label>
     <input style="cursor: pointer;" name="email" type="text"/>
   </p>
   <p>
     <label>Message:</label>
     <textarea name="message"></textarea>
   </p>
   <p>

     <input type="submit" value="Send"/>
   </p>
 </form>

 <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
 <script>


     const constraints = {
         name: {
             presence: { allowEmpty: false }
         },
         email: {
             presence: { allowEmpty: false },
             email: true
         },
         message: {
             presence: { allowEmpty: false }
         }
     };

     const form = document.getElementById('contact-form');
     form.addEventListener('submit', function (event) {

         const formValues = {
             name: form.elements.name.value,
             email: form.elements.email.value,
             message: form.elements.message.value
         };


         const errors = validate(formValues, constraints);
         if (errors) {
             event.preventDefault();
             const errorMessage = Object
                 .values(errors)
                 .map(function (fieldValues) {
                     return fieldValues.join(', ')
                 })
                 .join("\n");

             alert(errorMessage);
         }
     }, false);
 </script>
</body>
</html>