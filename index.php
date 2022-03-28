<?php

session_start();
require "functions.php";

?>


<?php include "template/header.php"; ?>

<div class="container">
	<h1>Salut !</h1>

	<?php
	if (isConnected()) :
	?>

		<?php

		$pdo = connectDB();

		$queryPrepared = $pdo->prepare("SELECT * FROM iw_user");
		$queryPrepared->execute();
		$results = $queryPrepared->fetchAll();

		?>

		<table class="table">
			<thead>
				<tr>
					<th>id</th>
					<th>nom</th>
					<th>pseudo</th>
					<th>email</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($results as $user) : ?>
					<tr>
						<td><?php echo $user['id']; ?></td>
						<td><?php echo $user['pseudo']; ?></td>
						<td><?php echo $user['firstname']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td><button type="button" class="btn btn-danger"><a href="delUser.php?userId=<?php echo $user['id'] ?>">Supprimer</a></button> <button type="button" class="btn btn-primary"><a href="modify.php?userId=<?php echo $user['id'] ?>">Modifier</a></button></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	<?php endif; ?>

</div>


<?php include "template/footer.php"; ?>
