<?php
    $urls = array();
    $segments = $this->uri->segment_array();

    foreach($segments as $key=>$segment)
    {
        $urls[] = array(site_url(implode( '/',array_slice($segments,1,$key))),$segment);
    }

?>
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="<?php echo site_url('dashboard');?>"> <i class="feather icon-home"></i> </a>
    </li>
    <?php 
        foreach($urls as $key => $value)
        {
            echo '<li class="breadcrumb-item">';
            echo anchor($value[2], ucfirst($value[2]));
            echo ' </li>';
        }
    ?>
</ul>

