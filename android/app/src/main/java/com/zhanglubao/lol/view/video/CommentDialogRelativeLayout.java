package com.zhanglubao.lol.view.video;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.RelativeLayout;

/**
 * Created by rocks on 15-6-24.
 */
public class CommentDialogRelativeLayout extends RelativeLayout {
    private LayoutChangeListener mLayoutChangeListener;


    public CommentDialogRelativeLayout(Context context) {
        super(context);
    }

    public CommentDialogRelativeLayout(Context context, AttributeSet defStyleAttr) {
        super(context, defStyleAttr);
    }

    public CommentDialogRelativeLayout(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
    }

    protected void onLayout(boolean changed, int l, int t, int r, int b) {
        if (this.mLayoutChangeListener != null) {
            this.mLayoutChangeListener.onLayoutChange(changed);
        }
        super.onLayout(changed, l, t, r, b);
    }

    public void setLayoutListener(LayoutChangeListener layoutListener) {
        this.mLayoutChangeListener = layoutListener;
    }

    public static abstract interface LayoutChangeListener {
        public abstract void onLayoutChange(boolean changed);
    }


}
