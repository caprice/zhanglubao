package com.zhanglubao.lol.view.user;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.evenbus.LoginEvent;
import com.umeng.socialize.bean.SHARE_MEDIA;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 15-6-15.
 */
public class LoginDialog extends Dialog {

    Context context;


    public LoginDialog(Context context) {
        super(context, R.style.Theme_Dialog_Base);
        this.context = context;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setContentView(R.layout.dlg_login);
        super.onCreate(savedInstanceState);
        setCancelable(true);
        setCanceledOnTouchOutside(true);

        ImageView weiboImageView = (ImageView) findViewById(R.id.weiboBtn);
        ImageView qqImageView = (ImageView) findViewById(R.id.qzoneBtn);
        weiboImageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                weibo();
            }
        });
        qqImageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                qq();
            }
        });
    }

    public void weibo() {
        dismiss();
        EventBus.getDefault().post(new LoginEvent(SHARE_MEDIA.SINA));
    }

    public void qq() {
        dismiss();
        EventBus.getDefault().post(new LoginEvent(SHARE_MEDIA.QQ));
    }


}
