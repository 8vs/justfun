
		<style>
			html { box-sizing: border-box; }

			*,
			*:before,
			*:after { box-sizing: inherit; }

			.grid {
				width: 100%;
				max-width: 60rem;
				margin-left: auto;
				margin-right: auto;

				display: flex;
				-webkit-box-orient: horizontal;
				-webkit-box-direction: normal;
				flex-direction: row;
				flex-wrap: wrap;
			}

			.grid-block {
				width: 50%;
				min-height: 11.25rem;
				padding: 1rem;
			}

			.image-grid .tile-link:hover .tile-img {
				top: -1rem;
				left: -1rem;
			}

			.image-grid .tile-img {
				position: relative;
				top: 0;
				left: 0;
				-webkit-transition-property: opacity, top, left, box-shadow;
				transition-property: opacity, top, left, box-shadow;
			}

			.tile-img {
				display: block;
				width: 100%;
				height: auto;
			}

			.tile-link:hover .tile-img1 {
				box-shadow: 5px 5px rgba(244, 170, 200, 0.4),
				10px 10px rgba(244, 170, 200, 0.3), 15px 15px rgba(244, 170, 200, 0.2),
				20px 20px rgba(244, 170, 200, 0.1), 25px 25px rgba(244, 170, 200, 0.05);
			}

			.tile-link:hover .tile-img2 {
				box-shadow: 5px 5px rgba(45, 186, 233, 0.4), 10px 10px rgba(45, 186, 233, 0.3),
				15px 15px rgba(45, 186, 233, 0.2), 20px 20px rgba(45, 186, 233, 0.1),
				25px 25px rgba(45, 186, 233, 0.05);
			}

			.tile-link:hover .tile-img4 {
				box-shadow: 5px 5px rgba(199, 21, 133, 0.4),
				10px 10px rgba(199, 21, 133, 0.3), 15px 15px rgba(199, 21, 133, 0.2),
				20px 20px rgba(199, 21, 133, 0.1), 25px 25px rgba(199, 21, 133, 0.05);
			}

			.tile-link:hover .tile-img3 {
				box-shadow: 5px 5px rgba(82, 119, 192, 0.4), 10px 10px rgba(82, 119, 192, 0.3),
				15px 15px rgba(82, 119, 192, 0.2), 20px 20px rgba(82, 119, 192, 0.1),
				25px 25px rgba(82, 119, 192, 0.05);
			}

			.tile-link:hover .tile-img5 {
				box-shadow: 5px 5px rgba(255, 99, 71, 0.4),
				10px 10px rgba(255, 99, 71, 0.3), 15px 15px rgba(255, 99, 71, 0.2),
				20px 20px rgba(255, 99, 71, 0.1), 25px 25px rgba(255, 99, 71, 0.05);
			}

			.tile-link:hover .tile-img6 {
				box-shadow: 5px 5px rgba(102, 205, 170, 0.4),
				10px 10px rgba(102, 205, 170, 0.3), 15px 15px rgba(102, 205, 170, 0.2),
				20px 20px rgba(102, 205, 170, 0.1), 25px 25px rgba(102, 205, 170, 0.05);
			}

			.tile-link:hover .tile-img7 {
				box-shadow: 5px 5px rgba(91, 209, 250, 0.4), 10px 10px rgba(91, 209, 250, 0.3),
				15px 15px rgba(91, 209, 250, 0.2), 20px 20px rgba(91, 209, 250, 0.1),
				25px 25px rgba(91, 209, 250, 0.05);
			}

			.tile-link:hover .tile-img8 {
				box-shadow: 5px 5px rgba(238, 130, 238, 0.4),
				10px 10px rgba(238, 130, 238, 0.3), 15px 15px rgba(238, 130, 238, 0.2),
				20px 20px rgba(238, 130, 238, 0.1), 25px 25px rgba(238, 130, 238, 0.05);
			}

			.tile-link:hover .tile-img9 {
				box-shadow: 5px 5px rgba(188, 97, 129, 0.4), 10px 10px rgba(188, 97, 129, 0.3),
				15px 15px rgba(188, 97, 129, 0.2), 20px 20px rgba(188, 97, 129, 0.1),
				25px 25px rgba(188, 97, 129, 0.05);
			}

			.tile-link:hover .tile-img10 {
				box-shadow: 5px 5px rgba(4, 140, 231, 0.4), 10px 10px rgba(4, 140, 231, 0.3),
				15px 15px rgba(4, 140, 231, 0.2), 20px 20px rgba(4, 140, 231, 0.1),
				25px 25px rgba(4, 140, 231, 0.05);
			}
			
			a.button9 {
				position: relative;
				display: inline-block;
				color: #777674;
				font-weight: bold;
				text-decoration: none;
				text-shadow: rgba(255,255,255,.5) 1px 1px, rgba(100,100,100,.3) 3px 7px 3px;
				user-select: none;
				padding: 1em 2em;
				outline: none;
				border-radius: 3px / 100%;
				background-image:
				linear-gradient(45deg, rgba(255,255,255,.0) 30%, rgba(255,255,255,.8), rgba(255,255,255,.0) 70%),
				linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0) 20%, rgba(255,255,255,0) 90%, rgba(255,255,255,.3)),
				linear-gradient(to right, rgba(125,125,125,1), rgba(255,255,255,.9) 45%, rgba(125,125,125,.5)),
				linear-gradient(to right, rgba(125,125,125,1), rgba(255,255,255,.9) 45%, rgba(125,125,125,.5)),
				linear-gradient(to right, rgba(223,190,170,1), rgba(255,255,255,.9) 45%, rgba(223,190,170,.5)),
				linear-gradient(to right, rgba(223,190,170,1), rgba(255,255,255,.9) 45%, rgba(223,190,170,.5));
				background-repeat: no-repeat;
				background-size: 200% 100%, auto, 100% 2px, 100% 2px, 100% 1px, 100% 1px;
				background-position: 200% 0, 0 0, 0 0, 0 100%, 0 4px, 0 calc(100% - 4px);
				box-shadow: rgba(0,0,0,.5) 3px 10px 10px -10px;
			}
			a.button9:hover {
				transition: .5s linear;
				background-position: -200% 0, 0 0, 0 0, 0 100%, 0 4px, 0 calc(100% - 4px);
			}
			a.button9:active {
				top: 1px;
			}
		</style>
	
	<p> </p>
	
	<div class="body-block">
		<div class="grid image-grid">

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img1" src="assets/images/photos/page/1.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img2" src="assets/images/photos/page/2.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img3" src="assets/images/photos/page/3.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img4" src="assets/images/photos/page/4.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img5" src="assets/images/photos/page/5.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img6" src="assets/images/photos/page/6.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img7" src="assets/images/photos/page/7.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img8" src="assets/images/photos/page/8.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img9" src="assets/images/photos/page/9.jpg" alt="Image">
					</a>
				</div>
			</div>

			<div class="grid-block">
				<div class="tile">
					<a class="tile-link" href="#">
						<img class="tile-img tile-img10" src="assets/images/photos/page/10.jpg" alt="Image">
					</a>
				</div>
			</div>
		</div>
		</div>