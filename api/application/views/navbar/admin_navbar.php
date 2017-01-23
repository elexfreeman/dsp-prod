<div data-collapse="small" data-animation="over-left" data-duration="400" data-contain="1" class="w-nav main-nav-bar">
    <div class="w-container"><a href="/" class="w-nav-brand logo"></a>
        <nav role="navigation" class="w-nav-menu">
            <a href="#" class="w-nav-link nav-menu-link">Врач: Терешкова Л.Н.</a>
            <div data-delay="0" class="w-dropdown">
                <div class="w-dropdown-toggle">
                    <div class="colorwhite">Настройки</div>
                    <div class="w-icon-dropdown-toggle colorwhite"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a href="/auth" class="w-dropdown-link drommenuitem">Пользователи</a>

                </nav>
            </div>
            <a href="/auth/logout" class="w-nav-link nav-menu-link">Выход</a>
        </nav>
        <nav role="navigation" class="w-nav-menu nav-menu-left">
            <div data-delay="0" class="w-dropdown">
                <div class="w-dropdown-toggle">
                    <div class="colorwhite">Формы</div>
                    <div class="w-icon-dropdown-toggle colorwhite"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a href="/f89" class="w-dropdown-link drommenuitem">Ф39</a>
                    <a href="/f30" class="w-dropdown-link drommenuitem">Ф30</a>
                </nav>
            </div>
            <div data-delay="0" class="w-dropdown">
                <div class="w-dropdown-toggle">
                    <div class="colorwhite">Справочники</div>
                    <div class="w-icon-dropdown-toggle colorwhite"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a href="/reference/doctors" class="w-dropdown-link drommenuitem">Доктора</a>
                    <?php foreach ($navbar['reference'] as $reference) {
                        ?>
                        <a href="/reference/reference/info/<?php echo $reference->login;?>" class="w-dropdown-link drommenuitem"><?php echo $reference->Comment;?></a>
                    <?php

                    }
                    ?>

                </nav>
            </div>
            <div data-delay="0" class="w-dropdown">
                <div class="w-dropdown-toggle">
                    <div class="colorwhite">Отчеты</div>
                    <div class="w-icon-dropdown-toggle colorwhite"></div>
                </div>
                <nav class="w-dropdown-list">
                    <a href="#" class="w-dropdown-link drommenuitem">Link 1</a>
                    <a href="#" class="w-dropdown-link drommenuitem">Link 2</a>
                    <a href="#" class="w-dropdown-link drommenuitem">Link 3</a>
                </nav>
            </div>
        </nav>
        <div class="w-nav-button">
            <div class="w-icon-nav-menu"></div>
        </div>
    </div>
</div>