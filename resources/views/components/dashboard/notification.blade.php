<div id="notificationsWrapper" class="notifications-wrapper">
    <div class="notification">
        <div class="content-wrapper">
            <div class="icon">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="content">
                <div class="header">
                    <div class="title">
                        @{{ title }}
                    </div>
                    <button class="close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <p>@{{ message }}</p>
                <div class="date">@{{ date }}</div>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="primary">@{{ primaryBtn }}</button>
            <button type="button" class="secondary">@{{ secondarybtn }}</button>
        </div>
    </div>
</div>
