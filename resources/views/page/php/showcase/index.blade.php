<?php
	class Showcase {
		public static $test = 9;

		public function __construct($className = ""){
			$this->className = $className;
			$this->class = new ReflectionClass($className);
		}

		public function traits():array{
			return $this->class->getTraits();
		}

		public function traitNames():array{
			return $this->class->getTraitNames();
		}

		public function properties():array{
			return $this->class->getStaticProperties();
		}

		public function methods():array{
			return $this->class->getMethods();
		}

		public function isAbstract():bool {
			return $this->class->isAbstract();
		}
	}
	$name = "Showcase";
	$meta = new Showcase($name);
?>
<html>
	<head>
	</head>
	<body>
		<table>
			<?php
				echo "<tr><td colspan='2'><h1>" . $name . "</h1></td></tr>";
				echo "<tr><td colspan='2'><h2>" . "Methods" . "</h2></td></tr>";
				foreach($meta->methods() as $reflectionMethod){
					$rfmd = new ReflectionMethod($name, $reflectionMethod->name);
					echo "<tr><td>" . ($rfmd->isPublic() ? "+ " : ($rfmd->isPrivate() ? "- " : "")) . ($rfmd->hasReturnType() ? $rfmd->getReturnType()." : " : "") . $reflectionMethod->name . "</td><td>";

					$params = $rfmd->getParameters();

					echo "(";
					foreach($params as $rfpm){
						if($rfpm->isPassedByReference()) echo "&";

						echo $rfpm->getName();
						if($rfpm->isDefaultValueAvailable()){
							$v = $rfpm->getDefaultValue();
							echo " = " . (is_string($v)?"'":"") . $v . (is_string($v)?"'":"");
						}

						if($rfpm != end($params)){
							echo ",";
						}
					}
					echo ")";

					echo "</td></tr>";
				}
				echo "<tr><td colspan='2'><h2>Properties</h2></td></tr>";

				foreach($meta->properties() as $key => $value){
					echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
				}

				$traits = $meta->traits();
				echo "<tr><td colspan='2'><h2>Traits</h2></td></tr>";
				foreach($traits as $trait){
					echo "<tr><td>" . $trait . "</td></tr>";
				}
			?>
		</table>
	</body>
</html>
