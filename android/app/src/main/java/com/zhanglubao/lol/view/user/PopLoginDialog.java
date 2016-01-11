package com.zhanglubao.lol.view.user;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.evenbus.PopLoginChoseEvent;
import com.umeng.socialize.bean.SHARE_MEDIA;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 15-7-7.
 */
public class PopLoginDialog extends Dialog {

    Context context;


    public PopLoginDialog(Context context) {
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
        EventBus.getDefault().post(new PopLoginChoseEvent(SHARE_MEDIA.SINA));
    }

    public void qq() {
        dismiss();
        EventBus.getDefault().post(new PopLoginChoseEvent(SHARE_MEDIA.QQ));
    }


}
