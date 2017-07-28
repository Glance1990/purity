<?php
// print loader's CSS code 

function gg_loaders_switch() {
	include_once(MG_DIR .'/functions.php');
	$color = get_option('gg_loader_color', '#888888');
	
	switch(get_option('gg_loader', 'default')) {
		
		/* media grid loader */
		case 'default':
		default:
			?>
            .ggl_1, .ggl_2, .ggl_3, .ggl_4 {
                background-color: <?php echo $color ?>;
                width: 12px;
                height: 12px;
                position: absolute;
                top: 0;
                left: 0;
                
                -webkit-transform-origin: 	0 50%;
                -ms-transform-origin: 		0 50%;
                transform-origin: 			0 50%;	
                
                -webkit-animation: 	gg_loader 1.7s infinite ease-in-out;
                animation: 			gg_loader 1.7s infinite ease-in-out;
                
                -webkit-transform: 	rotateX(90deg);
                -ms-transform: 		rotateX(90deg);
                transform: 			rotateX(90deg);	
            }
            .ggl_2 {
                top: 0;
                left: 14px;
                -webkit-animation-delay: 0.2s;
                animation-delay: 0.2s;
            }
            .ggl_3 {
                top: 14px;
                left: 14px;
                -webkit-animation-delay: 0.4s;
                animation-delay: 0.4s;
            }
            .ggl_4 {
                top: 14px;
                left: 0px;
                -webkit-animation-delay: 0.6s;
                animation-delay: 0.6s;
            }
            @-webkit-keyframes gg_loader {
                20%, 80%, 100% {-webkit-transform: rotateX(90deg);}
                40%, 60% {-webkit-transform: rotateX(0deg);}
            }
            @keyframes gg_loader {
                20%, 80%, 100% {transform: rotateX(90deg);}
                40%, 60% {transform: rotateX(0deg);}
            }
            <?php
			break;
		
			
			
		/* rotating square */
		case 'rotating_square':
			?>
			.gg_loader {
                background-color: <?php echo $color ?>;
              
                -webkit-animation: gg-rotateplane 1.2s infinite ease-in-out;
                animation: gg-rotateplane 1.2s infinite ease-in-out;
            }
            .gg_grid_wrap .gg_loader {
                width: 32px;
                height: 32px;	
                margin-top: -16px;
                margin-left: -16px;
            }
            @-webkit-keyframes gg-rotateplane {
                0% 	{-webkit-transform: perspective(120px);}
                50% 	{-webkit-transform: perspective(120px) rotateY(180deg);}
                100% 	{-webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg);}
            }
            @keyframes gg-rotateplane {
                0%	{transform: perspective(120px) rotateX(0deg) rotateY(0deg);} 
                50%	{transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);} 
                100%	{transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);}
            }
			<?php
			break;
			
			
			
		/* overlapping circles */
		case 'overlapping_circles':
			?>
            .gg_loader div {
                background-color: <?php echo $color ?>;
            }
			.gg_loader {
                width: 32px;
                height: 32px;	
                margin-top: -16px;
                margin-left: -16px;
            }
            .ggl_1, .ggl_2 {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                opacity: 0.6;
                position: absolute;
                top: 0;
                left: 0;
                
                -webkit-animation: gg-bounce 1.8s infinite ease-in-out;
                animation: gg-bounce 1.8s infinite ease-in-out;
            }
            .ggl_2 {
                -webkit-animation-delay: -1.0s;
                animation-delay: -1.0s;
            }
            
            @-webkit-keyframes gg-bounce {
                0%, 100% {-webkit-transform: scale(0.0);}
                50% {-webkit-transform: scale(1.0);}
            }
            @keyframes gg-bounce {
                0%, 100% {transform: scale(0.0);} 
                50% {transform: scale(1.0);}
            }
			<?php
			break;
			
			
			
		/* stretching rectangles */
		case 'stretch_rect':
			?>
			.gg_loader div {
                background-color: <?php echo $color ?>;
            }
            .ggl_1, .ggl_2, .ggl_3 {
                height: 100%;
                width: 6px;
                display: inline-block;
                position: absolute;
                
                -webkit-animation: gg-stretchdelay 1.1s infinite ease-in-out;
                animation: gg-stretchdelay 1.1s infinite ease-in-out;
            }
            .ggl_2 {
                left: 10px;
                -webkit-animation-delay: -1s;
                animation-delay: -1s;
            }
            .ggl_3 {
                right: 0;
                -webkit-animation-delay: -.9s;
                animation-delay: -.9s;
            }
            @-webkit-keyframes gg-stretchdelay {
                0%, 40%, 100% {-webkit-transform: scaleY(0.6);}  
                20% {-webkit-transform: scaleY(1.1);}
            }
            @keyframes gg-stretchdelay {
                0%, 40%, 100% {transform: scaleY(0.6);}  
                20% {transform: scaleY(1.1);}
            }
			<?php
			break;
			
			
			
		/* spin and fill square */
		case 'spin_n_fill_square':
			?>
            .gg_loader {
                border-color: <?php echo $color ?>;
            }
            .gg_loader div {
                background-color: <?php echo $color ?>;
            }
            
            .gg_loader {
                border-size: 3px;
                border-style: solid;
                
                -webkit-animation: gg_spinNfill 2.3s infinite ease;
                animation: gg_spinNfill 2.3s infinite ease;
            }
            .ggl_1 {
                vertical-align: top;
                width: 100%;
                
                -webkit-animation: gg_spinNfill-inner 2.3s infinite ease-in;
                animation: gg_spinNfill-inner 2.3s infinite ease-in;
            }
            
            @-webkit-keyframes gg_spinNfill {
                0% {-webkit-transform: rotate(0deg);}
                25%, 50% {-webkit-transform: rotate(180deg);}
                75%, 100% {-webkit-transform: rotate(360deg);}
            }
            @keyframes gg_spinNfill {
                0% {transform: rotate(0deg);}
                25%, 50%  {transform: rotate(180deg);}
                75%, 100% {transform: rotate(360deg);}
            }
            @-webkit-keyframes gg_spinNfill-inner {
                0%, 25%, 100% {height: 0%;}
                50%, 75% {height: 100%;}
            }
            @keyframes gg_spinNfill-inner {
                0%, 25%, 100% {height: 0%;}
                50%, 75% {height: 100%;}
            }
			<?php
			break;
			
			
			
		/* pulsing circle */
		case 'pulsing_circle':
			?>
            .gg_loader {
                border-radius: 100%;  
                background-color: <?php echo $color ?>;
                
                -webkit-animation: gg-scaleout 1.0s infinite ease-in-out;
                animation: gg-scaleout 1.0s infinite ease-in-out;
            }
            .gg_grid_wrap .gg_loader {
                width: 36px;
                height: 36px;	
                margin-top: -18px;
                margin-left: -18px;
            }
            @-webkit-keyframes gg-scaleout {
                0% { -webkit-transform: scale(0);}
                100% {
                  -webkit-transform: scale(1.0);
                  opacity: 0;
                }
            }
            @keyframes gg-scaleout {
                0% {transform: scale(0);} 
                100% {
                  transform: scale(1.0);
                  opacity: 0;
                }
            }
			<?php
			break;	
			
			
			
		/* spinning dots */
		case 'spinning_dots':
			?>
            .gg_loader div {
                background-color: <?php echo $color ?>;
            }
            .gg_loader {
              text-align: center;
              -webkit-animation: gg-rotate 1.6s infinite linear;
              animation: gg-rotate 1.6s infinite linear;
            }
            .gg_grid_wrap .gg_loader {
                width: 36px;
                height: 36px;	
                margin-top: -18px;
                margin-left: -18px;
            }
            .ggl_1, .ggl_2 {
                width: 57%;
                height: 57%;
                display: inline-block;
                position: absolute;
                top: 0;
                border-radius: 100%;
                
                -webkit-animation: gg-bounce 1.6s infinite ease-in-out;
                animation: gg-bounce 1.6s infinite ease-in-out;
            }
            .ggl_2 {
                top: auto;
                bottom: 0;
                -webkit-animation-delay: -.8s;
                animation-delay: -.8s;
            }
            @-webkit-keyframes gg-rotate {
                0% { -webkit-transform: rotate(0deg) }
                100% { -webkit-transform: rotate(360deg) }
            }
            @keyframes gg-rotate { 
                0% { transform: rotate(0deg); -webkit-transform: rotate(0deg) }
                100% { transform: rotate(360deg); -webkit-transform: rotate(360deg) }
            }
            @-webkit-keyframes gg-bounce {
                0%, 100% {-webkit-transform: scale(0);}
                50% {-webkit-transform: scale(1);}
            }
            @keyframes gg-bounce {
                0%, 100% {transform: scale(0.0);} 
                50% {transform: scale(1.0);}
            }
			<?php
			break;	
			
			
			
		/* appearing cubes */
		case 'appearing_cubes':
			?>
            .gg_loader div {
                background-color: <?php echo $color ?>;
            }
            .ggl_1, .ggl_2, .ggl_3, .ggl_4 {
                width: 50%;
                height: 50%;
                float: left;
                
                -webkit-animation:	gg-cubeGridScaleDelay 1.3s infinite ease-in-out;
                animation: 			gg-cubeGridScaleDelay 1.3s infinite ease-in-out; 
            }
            .gg_grid_wrap .gg_loader {
                width: 36px;
                height: 36px;	
                margin-top: -18px;
                margin-left: -18px;
            }
            .ggl_1, .ggl_4 {
              	-webkit-animation-delay: .1s;
                      animation-delay: .1s; 
            }
            .ggl_2 {
              	-webkit-animation-delay: .2s;
                		animation-delay: .2s; 
            }
            @-webkit-keyframes gg-cubeGridScaleDelay {
                0%, 70%, 100% {
                  -webkit-transform: scale3D(1, 1, 1);
                          transform: scale3D(1, 1, 1);
                } 35% {
                  -webkit-transform: scale3D(0, 0, 1);
                          transform: scale3D(0, 0, 1); 
                }
            }
            @keyframes gg-cubeGridScaleDelay {
                0%, 70%, 100% {
                  -webkit-transform: scale3D(1, 1, 1);
                          transform: scale3D(1, 1, 1);
                } 35% {
                  -webkit-transform: scale3D(0, 0, 1);
                          transform: scale3D(0, 0, 1);
                } 
            }
			<?php
			break;
			
			
			
		/* folding cube */
		case 'folding_cube':
			?>
            .gg_loader div:before {
                background-color: <?php echo $color ?>;
            }
            .gg_loader {
              -webkit-transform: rotateZ(45deg);
                      transform: rotateZ(45deg);
            }
            .ggl_1, .ggl_2, .ggl_3, .ggl_4 {
              float: left;
              width: 50%;
              height: 50%;
              position: relative;
              -webkit-transform: scale(1.1);
                  -ms-transform: scale(1.1);
                      transform: scale(1.1); 
            }
            .gg_loader div:before {
              content: '';
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              -webkit-animation: gg-foldCubeAngle 2.3s infinite linear both;
                      animation: gg-foldCubeAngle 2.3s infinite linear both;
                      
              -webkit-transform-origin: 100% 100%;
                  -ms-transform-origin: 100% 100%;
                      transform-origin: 100% 100%;
            }
            .ggl_2 {
              -webkit-transform: scale(1.1) rotateZ(90deg);
                      transform: scale(1.1) rotateZ(90deg);
            }
            .ggl_3 {
              -webkit-transform: scale(1.1) rotateZ(270deg);
                      transform: scale(1.1) rotateZ(270deg);
            }
            .ggl_4 {
              -webkit-transform: scale(1.1) rotateZ(180deg);
                      transform: scale(1.1) rotateZ(180deg);
            }
            .gg_loader .ggl_2:before {
              -webkit-animation-delay: 0.3s;
                      animation-delay: 0.3s;
            }
            .gg_loader .ggl_3:before {
              -webkit-animation-delay: 0.9s;
                      animation-delay: 0.9s;
            }
            .gg_loader .ggl_4:before {
              -webkit-animation-delay: 0.6s;
                      animation-delay: 0.6s; 
            }
            @-webkit-keyframes gg-foldCubeAngle {
              0%, 10% {
              	-webkit-transform: perspective(140px) rotateX(-180deg);
                opacity: 0; 
              } 
              25%, 75% {
                -webkit-transform: perspective(140px) rotateX(0deg);
                opacity: 1; 
              } 
              90%, 100% {
                -webkit-transform: perspective(140px) rotateY(180deg);
                opacity: 0; 
              } 
            }
            @keyframes gg-foldCubeAngle {
              0%, 10% {
                transform: perspective(140px) rotateX(-180deg);
                opacity: 0; 
              } 
              25%, 75% {
                transform: perspective(140px) rotateX(0deg);
                opacity: 1; 
              } 
              90%, 100% {
                transform: perspective(140px) rotateY(180deg);
                opacity: 0; 
              }
            }
			<?php
			break;
			
			
			
		/* old-style circles spinner */
		case 'old_style_spinner':
			?>
            .gg_loader div:before {
                color: <?php echo $color ?>;
            }
			.gg_loader {            	
                font-size: 20px;
                border-radius: 50%;
  
                -webkit-animation: gg-circles-spinner 1.3s infinite linear;
                animation: gg-circles-spinner 1.3s infinite linear;
                
                -webkit-transform: 	scale(0.28) translateZ(0);
                transform: 			scale(0.28) translateZ(0);	
            }
            @-webkit-keyframes gg-circles-spinner {
              0%,
              100%	{box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;}
              12.5% {box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
              25%	{box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
              37.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;}
              50%	{box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;}
              62.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;}
              75% 	{box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;}
              87.5% {box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;}
            }
            @keyframes gg-circles-spinner {
              0%,
              100% 	{box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;}
              12.5% {box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
              25% 	{box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
              37.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;}
              50% 	{box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;}
              62.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;}
              75% 	{box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;}
              87.5% {box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;}
            }
			<?php
			break;
			
			
			
		/* minimal spinner */
		case 'minimal_spinner':
			?>
            .gg_loader .ggl_1 {
            	border-color: <?php echo gg_hex2rgba($color, '.25').' '.gg_hex2rgba($color, '.25').' '.$color ?>;
            }
			.gg_loader {
                width: 34px;
                height: 34px;
                margin-top: -17px;
                margin-left: -17px;	
            }
            .ggl_1,
            .ggl_1:after {
                border-radius: 50%;
                box-sizing: border-box !important;	
                height: 100%;
            }
            .ggl_1 {
                background: none !important;
                font-size: 10px;
                border-size: 6px;
                border-style: solid;
                
                -webkit-animation: 	gg_minimal_spinner 1.05s infinite linear;
                animation: 			gg_minimal_spinner 1.05s infinite linear;
            }
            @-webkit-keyframes gg_minimal_spinner {
                0% {-webkit-transform: rotate(0deg);}
                100% {-webkit-transform: rotate(360deg);}
            }
            @keyframes gg_minimal_spinner {
                0% {transform: rotate(0deg);}
                100% {transform: rotate(360deg);}
            }
			<?php
			break;
			
			
			
		/* spotify-like spinner */
		case 'spotify_like':
			?>
            .ggl_1 {
                background: none !important;
                border-radius: 50%;
                font-size: 5px;
                height: 28%;
                margin-left: 36%;
                margin-top: 36%;
                width: 28%;
            
                -webkit-animation: 	gg_spotify .9s infinite ease;
                animation: 			gg_spotify .9s infinite ease;
            }
            
            @-webkit-keyframes gg_spotify {
              0%,
              100% {
                box-shadow: 0em -2.6em 0em 0em <?php echo $color ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>;
              }
              12.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.8em -1.8em 0 0em <?php echo $color ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>;
              }
              25% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 2.5em 0em 0 0em <?php echo $color ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              37.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.75em 1.75em 0 0em <?php echo $color ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              50% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 0em 2.5em 0 0em <?php echo $color ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              62.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em 1.8em 0 0em <?php echo $color ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              75% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -2.6em 0em 0 0em <?php echo $color ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              87.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em -1.8em 0 0em <?php echo $color ?>;
              }
            }
            @keyframes gg_spotify {
              0%,
              100% {
                box-shadow: 0em -2.6em 0em 0em <?php echo $color ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>;
              }
              12.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.8em -1.8em 0 0em <?php echo $color ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>;
              }
              25% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 2.5em 0em 0 0em <?php echo $color ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              37.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.75em 1.75em 0 0em <?php echo $color ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              50% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 0em 2.5em 0 0em <?php echo $color ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              62.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em 1.8em 0 0em <?php echo $color ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              75% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -2.6em 0em 0 0em <?php echo $color ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              87.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em -1.8em 0 0em <?php echo $color ?>;
              }
            }
			<?php
			break;
		
		
		
		/* minimal spinner */
		case 'vortex':
			?>
            .ggl_1 {
                background: none !important;
                border-radius: 50%;
                font-size: 3px;
                height: 70%;
                margin-left: 15%;
                margin-top: 15%;
                width: 70%;
              
                -webkit-animation:	gg_vortex .45s infinite linear;
                animation: 			gg_vortex .45s infinite linear;
            }

            @-webkit-keyframes gg_vortex {
              0%,
              100% {
                box-shadow: 0em -2.6em 0em 0em <?php echo $color ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>;
              }
              12.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.8em -1.8em 0 0em <?php echo $color ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>;
              }
              25% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 2.5em 0em 0 0em <?php echo $color ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              37.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.75em 1.75em 0 0em <?php echo $color ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              50% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 0em 2.5em 0 0em <?php echo $color ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              62.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em 1.8em 0 0em <?php echo $color ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              75% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -2.6em 0em 0 0em <?php echo $color ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              87.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em -1.8em 0 0em <?php echo $color ?>;
              }
            }
            @keyframes gg_vortex {
              0%,
              100% {
                box-shadow: 0em -2.6em 0em 0em <?php echo $color ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>;
              }
              12.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.8em -1.8em 0 0em <?php echo $color ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>;
              }
              25% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 2.5em 0em 0 0em <?php echo $color ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              37.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 1.75em 1.75em 0 0em <?php echo $color ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              50% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, 0em 2.5em 0 0em <?php echo $color ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              62.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em 1.8em 0 0em <?php echo $color ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              75% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -2.6em 0em 0 0em <?php echo $color ?>, -1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>;
              }
              87.5% {
                box-shadow: 0em -2.6em 0em 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.8em -1.8em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 2.5em 0em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 1.75em 1.75em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, 0em 2.5em 0 0em <?php echo gg_hex2rgba($color, '.2') ?>, -1.8em 1.8em 0 0em <?php echo gg_hex2rgba($color, '.5') ?>, -2.6em 0em 0 0em <?php echo gg_hex2rgba($color, '.7') ?>, -1.8em -1.8em 0 0em <?php echo $color ?>;
              }
            }
			<?php
			break;
			
			
			
		/* bubbling dots */
		case 'bubbling_dots':
			?>
            .gg_loader div {
                background-color: <?php echo $color ?>;
            }
            .gg_loader {
                -webkit-transform: scale(1.4);
                      transform: scale(1.4);
            }
            .ggl_1, .ggl_2, .ggl_3 {
                border-radius: 35px;
                bottom: -8px;
                display: inline-block;
                height: 6px;
                margin: 0 2px 0 0;
                position: relative;
                width: 6px;
                
                -webkit-animation:	gg_bubbling ease .65s infinite alternate;	
                animation: 			gg_bubbling ease .65s infinite alternate;
            }
            .ggl_2 {
                -webkit-animation-delay: 0.212s;
                animation-delay: 0.212s;
            }
            .ggl_3 {
                margin-right: 0;
                -webkit-animation-delay: 0.425s;
                animation-delay: 0.425s;
            }
            @-webkit-keyframes gg_bubbling {
                0% 		{-webkit-transform: scale(1) translateY(0);}
                35%		{opacity: 1;}
                100% 	{-webkit-transform: scale(1.3) translateY(-15px); opacity: .3;}
            }
            @keyframes gg_bubbling {
                0% 		{transform: scale(1) translateY(0);}
                35%		{opacity: 1;}
                100% 	{transform: scale(1.3) translateY(-15px); opacity: .3;}
            }
			<?php
			break;	
			
			
		
		/* overlapping dots */
		case 'overlapping_dots':
			?>
            .gg_loader div:before,
            .gg_loader div:after {
                background-color: <?php echo $color ?>;
            }
            .ggl_1 {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                position: relative;
                vertical-align: middle;
                
                -webkit-animation: gg_overlap_dots1 1.73s infinite linear;
                animation: gg_overlap_dots1 1.73s infinite linear;
            }
            .ggl_1:before,
            .ggl_1:after {
                content:"";
                margin: -14px 0 0 -14px;
                width: 100%; 
                height: 100%;
                border-radius: 50%;
                position: absolute;
                top: 50%;
                left: 50%;
                
                -webkit-animation: gg_overlap_dots2 1.15s infinite ease-in-out;
                animation: gg_overlap_dots2 1.15s infinite ease-in-out;
            }
            .ggl_1:after { 
                -webkit-animation-direction: reverse;
                animation-direction: reverse;
            }
            
            @-webkit-keyframes gg_overlap_dots1 {
                0% {	-webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }
            @keyframes gg_overlap_dots1 {
                0% {	 transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            @-webkit-keyframes gg_overlap_dots2 {
                0%	 { -webkit-transform: scale(0.2); left:	 0%; }
                50%	{ -webkit-transform: scale(1.0); left:	50%; }
                100% { -webkit-transform: scale(0.2); left: 100%; opacity: 0.5; }
            }
            @keyframes gg_overlap_dots2 {
                0%	 { transform: scale(0.2); left:	 0%; }
                50%	{ transform: scale(1.0); left:	50%; }
                100% { transform: scale(0.2); left: 100%; opacity: 0.5; }
            }
			<?php
			break;
			
			
			
		/* fading circles */
		case 'fading_circles':
			?>
            .gg_loader div:before,
            .gg_loader div:after {
                background-color: <?php echo $color ?>;
            }
            .ggl_1 {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                position: relative;
                vertical-align: middle;
            }
            .ggl_1:before,
            .ggl_1:after {
                content: "";
                width: 100%; 
                height: 100%;
                border-radius: 50%;
                position: absolute;
                top: 0;
                left: 0;
                
                -webkit-transform: scale(0);
                transform: scale(0);
            
                -webkit-animation: 	gg_fading_circles 1.4s infinite ease-in-out;
                animation: 			gg_fading_circles 1.4s infinite ease-in-out;
            }
            .ggl_1:after { 
                -webkit-animation-delay: 0.7s;
                animation-delay: 0.7s;
            }
            @-webkit-keyframes gg_fading_circles {
                0%	 { -webkit-transform: translateX(-80%) scale(0); }
                50%	{ -webkit-transform: translateX(0)		scale(1); }
                100% { -webkit-transform: translateX(80%)	scale(0); }
            }
            @keyframes gg_fading_circles {
                0%	 { transform: translateX(-80%) scale(0); }
                50%	{ transform: translateX(0)		scale(1); }
                100% { transform: translateX(80%)	scale(0); }
            }
			<?php
			break;
		
	}
}
