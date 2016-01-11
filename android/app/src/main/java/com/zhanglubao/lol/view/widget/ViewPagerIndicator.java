package com.zhanglubao.lol.view.widget;

import android.annotation.SuppressLint;
import android.content.Context;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.zhanglubao.lol.R;

import java.util.ArrayList;
import java.util.List;

import static android.view.ViewGroup.LayoutParams.MATCH_PARENT;

/**
 * Created by rocks on 14-12-1.
 */
public class ViewPagerIndicator extends LinearLayout implements
        OnPageChangeListener {


    private ViewPager mViewPager;
    private ViewPager.OnPageChangeListener mListener;
    private List<TextView> views = new ArrayList<TextView>();
    private LayoutInflater inflater;

    public ViewPagerIndicator(Context context) {
        super(context);
        inflater = LayoutInflater.from(context);
    }

    public ViewPagerIndicator(Context paramContext,
                              AttributeSet paramAttributeSet) {
        super(paramContext, paramAttributeSet);
        inflater = LayoutInflater.from(paramContext);

    }

    @SuppressLint("NewApi")
    public ViewPagerIndicator(Context paramContext,
                              AttributeSet paramAttributeSet, int paramInt) {
        super(paramContext, paramAttributeSet, paramInt);
        inflater = LayoutInflater.from(paramContext);
    }

    public void initSubView(List<String> items) {
        int count = items.size();
        for (int i = 0; i < count; i++) {

            if (i == (count - 1)) {
                TextView textView = (TextView) inflater.inflate(
                        R.layout.nav_tab_item, null);
                String tag = items.get(i);

                textView.setText(tag);
                textView.setTag(i);
                views.add(textView);
                textView.setOnClickListener(new TabTextClickListener());
                addView(textView, new LinearLayout.LayoutParams(0, MATCH_PARENT, 1));
            } else {
                TextView textView = (TextView) inflater.inflate(
                        R.layout.nav_tab_middle_item, null);
                String tag = items.get(i);
                textView.setText(tag);
                textView.setTag(i);
                views.add(textView);
                textView.setOnClickListener(new TabTextClickListener());
                addView(textView, new LinearLayout.LayoutParams(0, MATCH_PARENT, 1));
                if (i==0)
                {
                    textView.setSelected(true);
                }
            }

        }

    }

    class TabTextClickListener implements OnClickListener {

        @Override
        public void onClick(View v) {
            Integer tag = (Integer) v.getTag();
            showCurrent(tag);
        }

    }

    public void showCurrent(int tag) {
        mViewPager.setCurrentItem(tag);
    }

    @Override
    public void onPageScrollStateChanged(int arg0) {
    }

    @Override
    public void onPageScrolled(int arg0, float arg1, int arg2) {
    }

    @Override
    public void onPageSelected(int position) {
        int count = views.size();
        for (int i = 0; i < count; i++) {
            TextView view = views.get(i);
            view.setSelected(false);
        }

        for (int i = 0; i < count; i++) {
            TextView view = views.get(i);
            if (i == position) {
                view.setSelected(true);
            }
        }
    }

    public void setViewPager(ViewPager view) {
        if (mViewPager == view) {
            return;
        }
        if (mViewPager != null) {
            mViewPager.setOnPageChangeListener(null);
        }
        mViewPager = view;
        view.setOnPageChangeListener(this);
    }
}
