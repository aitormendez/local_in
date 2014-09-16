<?php

$categ = '';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts("showposts=36&posts_per_page=36&paged=$paged");
if ( have_posts() ) :

$mess_out = "<div class='unique mosac'>";


if ( array_key_exists('filtro', $_GET) ) { $filtro = sanitize_text_field( $_GET['filtro'] ); } else { $filtro = ""; }
if ( array_key_exists('pn', $_GET) ) { $pn = sanitize_text_field( $_GET['pn'] ); } else { $pn = ""; }
if ( array_key_exists('pn2', $_GET) ) { $pn2 = sanitize_text_field( $_GET['pn2'] ); } else { $pn2 = ""; }

if($pn=="positivo"){$textoposinega= " - " . __('Positivo','whatif');}
elseif($pn=="negativo"){$textoposinega=" - " . __('Negativo','whatif');}
else { $textoposinega = ""; }
if($filtro=="2"){$textoextra=" - " . __('Arquitectura urbanismo','whatif');}
elseif($filtro=="3"){$textoextra=" - " . __('Comunidad ciudadana','whatif');}
elseif($filtro=="4"){$textoextra=" - " . __('Espacio público medioambiente','whatif');}
elseif($filtro=="5"){$textoextra=" - " . __('Movilidad','whatif');}
elseif($filtro=="6"){$textoextra=" - " . __('Otros','whatif');}
else { $textoextra = ""; }

$plvaria = "pl-mini.png";
$mnvaria = "mn-mini.png";

if ($pn == "positivo" AND $pn2=="positivo")
{ $plvaria="pl-mini.png";
 
}
if ($pn == "negativo" AND $pn2=="negativo")
{ $mnvaria="mn-mini.png";
 
}


if ($pn == "positivo" AND $pn2!="positivo")
{
$pn2="positivo";
$plvaria="pl-big.png";
}

if ($pn == "negativo" AND $pn2!="negativo" )
{
$pn2="negativo"; 
$mnvaria = "mn-big.png";
}


$valor=$pn;
$valor_query = "";
$valor_terms = get_terms($valor);
$count2 = 0;
foreach ( $valor_terms as $term ) {
$count2++;
if ( $count2 == 1) { $valor_query .= "$term->slug"; }
else { $valor_query .= ",$term->slug"; }
}



query_posts( "posts_per_page=-1&$valor=$valor_query&cat=$filtro&orderBy=meta_value_num&order=DESC" );

while ( have_posts() ) : the_post();
	// the image
	$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $post->ID ); 
	$attachments = get_posts($args);
	//if ( has_post_thumbnail() ) {
	if ( $attachments ) {
		//$img = get_the_post_thumbnail($post->ID, 'thumbnail');

		foreach ( $attachments as $attachment ) {
			//$img =  apply_filters( 'the_title' , $attachment->post_title );
			$img_link =  $attachment->guid;
			//$img_url = the_attachment_link( $attachment->ID , false );
			$img_thumb = wp_get_attachment_image($attachment->ID, 'thumbnail');
			
	         $img_link=  wp_get_attachment_url( $attachment->ID );
	    
		    $imagenLink = wp_get_attachment_link($attachment->ID, 'thumbnail');			
			//<a href='$img_link'>$img_thumb</a>
		
		$mess_out .= "
		<div class='mosac-img'>
			$imagenLink
		</div>
		

		
		
		";

		}
	}
	
	/*elseif (!$attachments) {
	
	$video = get_post_meta($post->ID, "video", $single = true);
	
   
      $imagenmin = miniatura_web($video, "thumbalizr", "1");
   
      echo '<img src="'.$imagen.'"><br>';

	
	
	
	
	 if ($video !="")
	 {
	
		$mess_out .= "
		<div class='mosac-img'>
			<a href='$video'><img src='$imagenmin' /></a>
		</div>
		";
		}

	}*/

endwhile;

$mess_out .= "</div><!-- end class unique mosac -->";

echo "<div id='titextra'><span>".$textoposinega."</span><span>".$textoextra."</span></div>";

echo $mess_out;

else:
endif;
wp_reset_query();

?>