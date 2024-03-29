<be-head>
    <link type="text/css" rel="stylesheet" href="<?php echo \Be\Ff\Be::getProperty('App.System')->getUrl(); ?>/Template/System/css/success.css">
</be-head>

<be-body>

    <div id="app" v-cloak>
        <div class="success-icon">
            <i class="el-icon-success"></i>
        </div>

        <div class="success-message">
            <?php echo $this->message; ?>
        </div>

        <?php
        if (isset($this->redirectUrl) && isset($this->redirectTimeout) && $this->redirectTimeout > 0 )
        {
            ?>
            <div class="success-timer">
                <span>{{timer}}</span> 秒后跳转到：<el-link type="primary" href="<?php echo $this->redirectUrl; ?>"><?php echo $this->redirectUrl; ?></el-link>
            </div>
            <?php
        }
        ?>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                timer: <?php echo isset($this->redirectTimeout) ? $this->redirectTimeout : 0; ?>
            },
            created: function () {
                <?php
                if (isset($this->redirectUrl)) {
                    if (isset($this->redirectTimeout) && $this->redirectTimeout > 0) {
                        ?>
                        var _this = this;
                        setInterval(function () {
                            _this.timer--;
                            if (_this.timer <= 0) {
                                window.location.href = "<?php echo $this->redirectUrl; ?>";
                            }
                        }, 1000);
                        <?php
                    } else {
                        ?>
                        window.location.href = "<?php echo $this->redirectUrl; ?>";
                        <?php
                    }
                }
                ?>
            }
        });
    </script>

</be-body>
