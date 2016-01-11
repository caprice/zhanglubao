package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.TitleFragmentAdapter;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.view.widget.TabPageIndicator;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rocks on 14-11-24.
 */
@EFragment(R.layout.fragment_home)
public class HomeFragment extends BaseFragment {

    @ViewById(R.id.home_indicator)
    TabPageIndicator viewPagerIndicator;
    @ViewById(R.id.home_pager)
    ViewPager viewPager;

    @AfterViews
    public void afterViews() {
        mPageName=HomeFragment.class.getName();
        List<String> items = Arrays.asList(getActivity().getResources().getStringArray(R.array.tab_home));
        List<Fragment> fragments = new ArrayList<Fragment>();
        fragments.add( HomeIndexFragment_.newInstance());
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_fresh_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_comm_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_album_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_master_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_match_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_owner_video));
        fragments.add(VideoGridFragment_.newInstance(QTUrl.home_other_video));

        TitleFragmentAdapter fragmentAdapter = new TitleFragmentAdapter(getChildFragmentManager(), viewPager, fragments, items);
        viewPager.setAdapter(fragmentAdapter);
        viewPagerIndicator.setViewPager(viewPager);


    }


}
