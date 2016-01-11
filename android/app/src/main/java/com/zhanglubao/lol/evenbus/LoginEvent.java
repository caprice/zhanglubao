package com.zhanglubao.lol.evenbus;

import com.umeng.socialize.bean.SHARE_MEDIA;

/**
 * Created by rocks on 15-6-16.
 */
public class LoginEvent {

    SHARE_MEDIA platform;

    public LoginEvent(SHARE_MEDIA platform) {
        this.platform = platform;
    }

    public SHARE_MEDIA getPlatform() {
        return platform;
    }

    public void setPlatform(SHARE_MEDIA platform) {
        this.platform = platform;
    }
}
