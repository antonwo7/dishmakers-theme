<div class="item">
    <div class="item-image">
        <img src="<?php echo $store['banner']; ?>" alt=""/>
    </div>
    <div class="item-footer">
        <div class="item-icon">
            <img src="<?php echo $store['gravatar']; ?>" alt=""/>
        </div>
        <div class="item-title">
            <a href="<?php echo $store['store_url']; ?>"><?php echo $store['store_name']; ?></a>
        </div>
        <div class="item-stars">
            <span style="width:<?php echo $store['store_rating']; ?>%;"></span>
        </div>
        <a href="<?php echo $store['store_url']; ?>" class="item-button">Visit</a>
    </div>
</div>
