package com.zhanglubao.lol.activity;

import com.zhanglubao.lol.evenbus.PopLoginChoseEvent;
import com.zhanglubao.lol.evenbus.PopLoginEvent;
import com.zhanglubao.lol.view.user.PopLoginDialog;
import com.umeng.socialize.bean.SHARE_MEDIA;

/**
 * Created by rocks on 15-6-13.
 */
public abstract class BasePlayerActivity extends  BaseFragmentActivity{

    /**
     * 全屏的回�?当程序全屏的时候应该将其他的view都设置为gone
     */
    public abstract void onFullscreenListener();

    /**
     * 小屏幕的回调 当程序全屏的时候应该显示其他的view
     */
    public abstract void onSmallscreenListener();

    public void onEvent(PopLoginEvent event) {
        PopLoginDialog loginDialog = new PopLoginDialog(this);
        loginDialog.show();
    }
    public void onEvent(PopLoginChoseEvent event) {

        SHARE_MEDIA share_media = event.getPlatform();
        if (share_media.equals(SHARE_MEDIA.QQ)) {
            loginQQ();
        } else if (share_media.equals(SHARE_MEDIA.SINA)) {
            loginSina();
        }
    }
}
