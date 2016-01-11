package com.zhanglubao.lol.evenbus;

import com.umeng.socialize.bean.SHARE_MEDIA;

/**
 * Created by rocks on 15-7-7.
 */
public class PopLoginChoseEvent {
    SHARE_MEDIA platform;

    public PopLoginChoseEvent(SHARE_MEDIA platform) {
        this.platform = platform;
    }

    public SHARE_MEDIA getPlatform() {
        return platform;
    }

    public void setPlatform(SHARE_MEDIA platform) {
        this.platform = platform;
    }
}
