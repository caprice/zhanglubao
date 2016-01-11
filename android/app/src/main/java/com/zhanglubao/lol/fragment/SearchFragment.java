package com.zhanglubao.lol.fragment;

import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.FragmentAdapter;
import com.zhanglubao.lol.view.widget.ViewPagerIndicator;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rocks on 14-11-24.
 */
@EFragment(R.layout.fragment_search)
public class SearchFragment extends  BaseFragment{

    @ViewById(R.id.search_indicator)
    ViewPagerIndicator viewPagerIndicator;
    @ViewById(R.id.search_pager)
    ViewPager viewPager;

    @AfterViews
    public void afterViews() {
        mPageName="searchfragment";
        List<String> items = Arrays.asList(getResources().getStringArray(R.array.tab_search));

        viewPagerIndicator.initSubView(items);

        List<Fragment> fragments = new ArrayList<Fragment>();
        fragments.add(new SearchIndexFragment_());
        fragments.add(SearchAlbumFragment_.newInstance());


        FragmentAdapter fragmentAdapter=new FragmentAdapter(getChildFragmentManager(),viewPager,fragments);
        viewPager.setAdapter(fragmentAdapter);
        viewPagerIndicator.setViewPager(viewPager);


    }

}
