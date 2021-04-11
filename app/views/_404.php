<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

	<title>Error 404 - Page not found</title>
	<link rel="shortcut icon" href="/assets/images/ico/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/components.css">
</head>

<body class="bg-full-screen-image">
	<section class="row flexbox-container mx-0">
		<div class="col-xl-7 cl-md-8 col-12 d-flex justify-content-center ">
			<div class="card-content">
				<div class="card-body text-center">
					<img src="/assets/images/pages/404.png" class="img-fluid align-self-center" alt="branding logo">
					<h1 class="font-large-2 my-1">404 - Page Not Found!</h1>
					<p class="p-2">
						We're sorry, the page you requeste could not be found. PLease go back to homepage or contact us at 
						<a href="mailto:<?= $_ENV["EMAIL"]??"example@example.com" ?>"><?= $_ENV["EMAIL"]??"example@example.com" ?></a>
					</p>
					<a 
					class="btn btn-primary btn-lg mt-2 waves-effect waves-light"
					href="/"
					>Back to Home</a>
				</div>
			</div>
		</div>
	</section>
</body>

</html>