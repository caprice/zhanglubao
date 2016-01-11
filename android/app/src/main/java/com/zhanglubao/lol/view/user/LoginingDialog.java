package com.zhanglubao.lol.view.user;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;

import com.zhanglubao.lol.R;

/**
 * Created by rocks on 15-6-16.
 */
public class LoginingDialog extends Dialog {

    Context context;


    public LoginingDialog(Context context) {
        super(context, R.style.Theme_Dialog_Base);
        this.context = context;
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setContentView(R.layout.dlg_logining);
        super.onCreate(savedInstanceState);

    }
}
