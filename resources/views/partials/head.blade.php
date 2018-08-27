<head>
	@include ("partials.bootstrap")
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style>
		.header {
			background-color:grey;
		}

		.well {
			margin-top: 20px;
		}

		.sampleRow {
			width: 100%;
		}

		.sampleImage {
			height: 50%;
			overflow-y: hidden;
		}

		.sampleButton {
			height: 50%;
			position: relative;
			overflow-y: hidden;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 33.3333333% 0px;
		}

		@media screen and (max-width: 768px){
			.sampleButton {
				display: none;
			}
		}
	</style>
</head>
