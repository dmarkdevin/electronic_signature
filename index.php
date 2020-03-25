<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>jQuery Signature Pad & Canvas Image</title>
		<link href="css/jquery.signaturepad.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="js/numeric-1.2.6.min.js"></script> 
		<script src="js/bezier.js"></script>
		<script src="js/jquery.signaturepad.js"></script> 
		
		<script type='text/javascript' src="js/html2canvas.js"></script>
		<script src="js/json2.min.js"></script>
		
		
		<style type="text/css">
			body{
				font-family:monospace;
				text-align:center;
			}
			#btnSaveSign{
				color: #fff;
				background: #f99a0b;
			}
			#btnSaveSign,
			#btnClearSign {
				padding: 5px;
				border: none;
				border-radius: 5px;
				font-size: 20px;
				margin-top: 10px;
			}
			#signArea{
				width:604px;
				margin: 80px auto;
			}
			.sign-container {
				width: 80%;
				margin: auto;
			}
			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}
			.tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			}
		</style>
	</head>
	<body>

		<h2>E-Signature, jQuery, PHP, AJAX, html2canvas.js</h2>
		
		<div id="signArea" >
			<h2 class="tag-ingo">Put signature below,</h2>
			<div class="sig sigWrapper" style="height:auto;">
				<div class="typed"></div>
				<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
				<canvas class="sign-pad2" id="sign-pad2" width="300" height="100" style='display:none'></canvas>
			</div>
		</div>
		
		<button id="btnSaveSign">Save Signature</button>
		<button id="btnClearSign">Clear Signature</button>


		
		<div class="sign-container">
		<?php
		$image_list = glob("./doc_signs/*.png");
		foreach($image_list as $image){
			//echo $image;
		?>
		<img src="<?php echo $image; ?>" class="sign-preview" />
		<?php
		
		}
		?>
		</div>
		
		
		<script>
			$(document).ready(function() {
				$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
			});
	
			$("#btnSaveSign").click(function(e){
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function (canvas) { 
						var canvas_img_data = canvas.toDataURL('image/png');
						var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						var getSignature = $('#signArea').signaturePad().getSignature();
					 
						if(getSignature === undefined || getSignature.length == 0){
							alert('signature is required');
						}else{
							//ajax call to save image inside folder
							$.ajax({
								url: 'save_sign.php',
								data: { img_data:img_data },
								type: 'post',
								dataType: 'json',
								success: function (response) {
									window.location.reload();
								}
							});
						}
					}
				});
			});

			$("#btnClearSign").click(function(e){
				$('#signArea').signaturePad().clearCanvas();
			});
		  </script> 
		

	</body>
</html>
