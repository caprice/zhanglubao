package com.zhanglubao.lol.view.video;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.Rect;
import android.os.Handler;
import android.os.Message;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.view.inputmethod.InputMethodManager;
import android.widget.PopupWindow;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.evenbus.CommentEvent;
import com.zhanglubao.lol.util.DetailUtil;
import com.zhanglubao.lol.util.Util;

import de.greenrobot.event.EventBus;

/**
 * Created by rocks on 15-6-23.
 */
public class CommentDialog {

    public static final int DATA = 2000;
    public static final int SENDCOMMENT = 2001;
    private View btn_send;
    private String commentid;
    private CommentDialogRelativeLayout contentView;
    Context context;
    Dialog dialog;
    private EditTextForMeizu edit;
    Rect frame = new Rect();
    Handler handler;
    private int height;
    LayoutInflater inflater;
    boolean isSoftVisible = false;
    private boolean isfist = true;
    private boolean isshow = false;
    int land_blank;
    PopupWindow.OnDismissListener ondisslistener;
    private View other;
    int port_blank;
    private String replayname;
    TextView text_lenght;
    String videoid;
    private int width;
    private WindowManager wm;

    public CommentDialog(Context context, String videoid, Handler hanlder, PopupWindow.OnDismissListener onDismissListener, int height) {
        this.context = context;
        this.handler = hanlder;
        this.ondisslistener = onDismissListener;
        this.height = height;
        this.inflater = LayoutInflater.from(context);
        this.videoid = String.valueOf(videoid);
        initDialog();
    }

    private void hideSoftInput() {
        ((InputMethodManager) this.contentView.getContext().getSystemService("input_method")).hideSoftInputFromWindow(this.edit.getWindowToken(), 0);
    }

    private void openSoftInput() {
        InputMethodManager inputMethodManager = (InputMethodManager) this.context.getSystemService("input_method");
        if (inputMethodManager.isActive()) {
            inputMethodManager.toggleSoftInput(0, 2);
        }
    }


    public void dismiss() {
        this.dialog.dismiss();
    }

    private boolean isLand() {
        Display getOrient = ((Activity) context).getWindowManager().getDefaultDisplay();
        return getOrient.getWidth() > getOrient.getHeight();
    }

    public void initDialog() {
        if (this.dialog == null) {
            this.dialog = new Dialog(this.context, R.style.CommentDialog);
            this.dialog.setContentView(R.layout.pop_video_comment_add);
            this.dialog.getWindow().setSoftInputMode(20);

            this.contentView = ((CommentDialogRelativeLayout) this.dialog.findViewById(R.id.commentDialogRelativeLayout));
            initView(this.contentView);
            this.contentView.setLayoutListener(new CommentDialogRelativeLayout.LayoutChangeListener() {
                                                   public void onLayoutChange(boolean paramAnonymousBoolean) {
                                                       CommentDialog.this.dialog.getWindow().getDecorView().getWindowVisibleDisplayFrame(CommentDialog.this.frame);
                                                       int i = CommentDialog.this.frame.bottom;
                                                       int j = CommentDialog.this.frame.right;
                                                       CommentDialog.this.port_blank = (DetailUtil.readPortScreen()[4] - DetailUtil.readPortScreen()[3]);
                                                       if (Math.max(i, j) + 200 < CommentDialog.this.port_blank) {
                                                           CommentDialog.this.isSoftVisible = true;
                                                           return;
                                                       }

                                                       if (CommentDialog.this.isSoftVisible) {
                                                           CommentDialog.this.dismiss();
                                                       }
                                                       CommentDialog.this.isSoftVisible = false;
                                                   }
                                               }

            );
            this.dialog.setOnDismissListener(new DialogInterface.OnDismissListener()

                                             {
                                                 public void onDismiss(DialogInterface dialogInterface) {
                                                     CommentDialog.this.hideSoftInput();
                                                     if (CommentDialog.this.ondisslistener != null) {
                                                         CommentDialog.this.ondisslistener.onDismiss();
                                                     }
                                                     String content = CommentDialog.this.edit.getText().toString();
                                                     Message message = new Message();
                                                     message.what = 2000;
                                                     message.obj = dialogInterface;
                                                     if (CommentDialog.this.handler != null) {
                                                         CommentDialog.this.handler.sendMessage(message);
                                                     }
                                                 }
                                             }

            );
            this.dialog.setOnCancelListener(new DialogInterface.OnCancelListener()

            {
                public void onCancel(DialogInterface dialogInterface) {
                    CommentDialog.this.dismiss();
                }
            });
        }
    }


    private void initView(View view) {
        this.edit = ((EditTextForMeizu) view.findViewById(R.id.edit_comment));
        this.btn_send = view.findViewById(R.id.btn_comment);
        this.other = view.findViewById(R.id.otherview);
        this.text_lenght = ((TextView) view.findViewById(R.id.text_length));
        this.other.setOnClickListener(new View.OnClickListener() {
            public void onClick(View clickView) {
                CommentDialog.this.dismiss();
            }
        });
        this.btn_send.setOnClickListener(new View.OnClickListener() {
            public void onClick(View paramAnonymousView) {
                String content = CommentDialog.this.edit.getText().toString();
                if (content.length() > 140) {
                    Util.showTips(R.string.video_detail_comment_over);
                    return;
                }
                if (content.length() <= 0) {

                    Util.showTips(R.string.video_detail_comment_none);
                    return;
                }
                EventBus.getDefault().post(new CommentEvent(commentid,content,videoid));
                CommentDialog.this.dismiss();
                CommentDialog.this.edit.setText("");



            }
        });
        this.edit.addTextChangedListener(new TextWatcher() {
            public void afterTextChanged(Editable buffer) {
            }

            public void beforeTextChanged(CharSequence buffer, int start,
                                          int before, int after) {

            }

            public void onTextChanged(CharSequence charSequence, int start, int before, int after) {
                CommentDialog.this.text_lenght.setText(140 - charSequence.length() + "");
                if (140 - charSequence.length() > 0) {
                    CommentDialog.this.text_lenght.setTextColor(-7829368);
                    return;
                }
                CommentDialog.this.text_lenght.setTextColor(-65536);
            }
        });
    }


    public boolean isShowing() {
        return (this.dialog != null) && (this.dialog.isShowing());
    }

    public void show(View paramView, String paramString) {
        this.dialog.show();
        this.edit.requestFocus();
        if (!TextUtils.isEmpty(this.replayname)) {
            this.edit.setHint("回复" + this.replayname + ": ");
        }
    }


}
