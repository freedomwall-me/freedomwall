<?php
require 'vendor/autoload.php';

session_start();

if (!array_key_exists("user", $_SESSION)) {
    header("Location: /login?redir=create");
}

require_once "classes/dbh.class.php";

$db = Database::getDatabase();
$published = false;
$editing = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists("edit", $_POST)) {
        $stmt = $db->prepare(
            "UPDATE user_works
			 SET title = :title,
			     tags = :tags,
				 body = :body,
				 type = :type
			 WHERE rowid = :rowid;"
        );

        $stmt->execute(
            [
                "title" => $_POST["title"],
                "tags" => $_POST["tags"],
                "body" => bzcompress($_POST["body"]),
                "type" => $_POST["type"],
                "rowid" => $_POST["edit"],
            ]
        );
    } else {
        $stmt = $db->prepare(
            "INSERT INTO user_works
			 VALUES (
				:uid,
				:title,
				:tags,
				:body,
				:type,
				:datetime
			 );"
        );

        $stmt->execute(
            [
                "uid" => $_SESSION["user"]["uid"],
                "title" => $_POST["title"],
                "tags" => $_POST["tags"],
                "body" => bzcompress($_POST["body"]),
                "type" => $_POST["type"],
                "datetime" => gmdate("Y-m-d h:i:s"),
            ]
        );
    }

    $published = true;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (array_key_exists("edit", $_GET)) {
        $editing = true;
        $id = $_GET["edit"];

        $stmt = $db->prepare(
            "SELECT * FROM user_works
		 	 WHERE rowid = :rowid;"
        );

        $stmt->execute(["rowid" => $id]);

        $work = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$work) {
            http_response_code(404);
            include_once "errors/404.php";
            die;
        }

        if ($work["uid"] !== $_SESSION["user"]["uid"] || $work["type"] != "draft") {
            http_response_code(403);
            include_once "errors/403.php";
            die;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "templates/head.template.php" ?>
	<script src="https://cdn.tiny.cloud/1/ugdxfv7ldx4nxeqyhu7xw7b4p4vvdvrdafophbluw6bg80un/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css">
</head>

<body>
	<?php include "templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<h1 class="mb-4">
			<?php if ($editing) : ?>
				Edit your work
			<?php else : ?>
				Create a short story
			<?php endif; ?>
		</h1>

		<form action="/create" method="post">
			<?php if ($published) : ?>
				<div class="alert alert-success alert-dismissible fade show form-outline mb-4">
					<?php if ($editing) : ?>
						Your work has been edited.
					<?php else : ?>
						Your work has been published.
					<?php endif; ?>
					Browse your profile to see it.
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
			<?php endif; ?>

			<input type="text" name="title" class="form-control form-control-lg" placeholder="Think of a good title..." required <?php if ($editing) : ?> value="<?= $work["title"] ?>" <?php endif; ?>>


			<input type="text" name="tags" class="form-control form-control-sm mt-1 mb-2" data-role="tagsinput" <?php if ($editing && $tags != null) : ?> value="<?=
                                                                                                                                                                    implode(								// split by ,
                                                                                                                                                                        ",",
                                                                                                                                                                        array_map(							// $work["tags"] is an array within an array, so
                                                                                                                                                                            // just return the value within the inner arrays
                                                                                                                                                                            fn ($value) => $value["value"],
                                                                                                                                                                            json_decode(					// it is a JSON string
                                                                                                                                                                                $work["tags"],
                                                                                                                                                                                true						// return as associative array
                                                                                                                                                                            )
                                                                                                                                                                        )
                                                                                                                                                                    ) ?>" <?php endif; ?>>
			<textarea class="form-control" id="ss" name="body" placeholder="Type here">
				<?php
                if ($editing) {
                    echo bzdecompress($work["body"]);
                }
?>
			</textarea>

			<div class="mt-3">
				<?php if ($editing) : ?>
					<input type="hidden" name="edit" value="<?= $_GET["edit"] ?>">
				<?php endif; ?>
				<button type="submit" class="btn btn-success btn-lg" name="type" value="release">
					Publish
				</button>
				<button type="submit" class="btn btn-outline-success btn-lg" name="type" value="draft">
					Save as draft
				</button>
			</div>
		</form>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/@yaireo/tagify@4.16.4/dist/tagify.min.js"></script>
	<script src="https://unpkg.com/@yaireo/tagify@4.16.4/dist/tagify.polyfills.min.js"></script>
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