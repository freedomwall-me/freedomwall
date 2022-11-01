<?php
session_start();

if (!array_key_exists("user", $_SESSION))
	header("Location: /login?redir=create");

require_once "../config.php";

$db = new PDO("sqlite:" . Config::DATABASE);
$published = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$db->exec(
		"INSERT INTO user_works (
			uid,
			title,
			tags,
			body,
			type,
			published_date
		 )
		 VALUES (
			'" . $_SESSION["user"]["uid"] . "',
			'" . $_POST["title"] . "',
			'" . $_POST["tags"] . "',
			'" . $_POST["body"] . "',
			'" . $_POST["type"] . "',
			'" . gmdate("ymd his A") . "'
		 );"
	);

	$published = true;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.tiny.cloud/1/ugdxfv7ldx4nxeqyhu7xw7b4p4vvdvrdafophbluw6bg80un/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css">
</head>

<body>
	<?php include "../templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<h1 class="mb-4">Create a short story</h1>

		<form action="/create" method="post">
			<?php if ($published) : ?>
				<div class="alert alert-success alert-dismissible fade show form-outline mb-4">
					Your story has been published.
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			<?php endif; ?>

			<input type="text" name="title" class="form-control form-control-lg" placeholder="Think of a good title..." required>
			<input type="text" name="tags" class="form-control form-control-sm mt-1 mb-2" data-role="tagsinput">

			<textarea class="form-control" id="ss" name="body" placeholder="Type here"></textarea>

			<div class="mt-3">
				<button type="submit" class="btn btn-success btn-lg" name="type" value="release">Publish</button>
				<button type="submit" class="btn btn-outline-success btn-lg" name="type" value="draft">Save as draft</button>
			</div>
		</form>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/@yaireo/tagify"></script>
	<script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
	<script>
		tinymce.init({
			selector: '#ss',
			plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect',
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
			tinycomments_mode: 'embedded',
			tinycomments_author: 'Author name',
			mergetags_list: [{
					value: 'First.Name',
					title: 'First Name'
				},
				{
					value: 'Email',
					title: 'Email'
				},
			]
		})

		let input = document.querySelector('input[name=tags]')
		new Tagify(input)
	</script>
</body>

</html>