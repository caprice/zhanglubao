package com.zhanglubao.lol.fragment;

import android.view.View;
import android.widget.GridView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleAlbumAdapter;
import com.zhanglubao.lol.model.SimpleAlbumModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.SimpleAlbumListEntity;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshGridView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 14-11-26.
 */
@EFragment(R.layout.fragment_search_album)
public class SearchAlbumFragment extends  BaseFragment{
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;


    @ViewById(R.id.search_album_grid)
    PullToRefreshGridView albumGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleAlbumModel> albums;
    SimpleAlbumAdapter albumAdapter;

    public static SearchAlbumFragment newInstance( ) {
        SearchAlbumFragment fragment = new SearchAlbumFragment_();

        return fragment;
    }

    @AfterViews
    public void afterViews() {
        mPageName=SearchAlbumFragment.class.getName();
        albums = new ArrayList<SimpleAlbumModel>();
        albumGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<GridView> refreshView) {
                page = 0;
                isPull = true;
                getData(page);
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<GridView> refreshView) {
                isPull = true;
                page++;
                getData(page);
            }
        });
        albumAdapter = new SimpleAlbumAdapter(getActivity(), albums);
        albumGird.setAdapter(albumAdapter);
        getData(page);
    }

    public void getData(int page) {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getUrlPage(QTUrl.cate_album_album, page, new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleAlbumListEntity simpleVideoListEntity = (SimpleAlbumListEntity) JSON.parseObject(response, SimpleAlbumListEntity.class);
                    recevieData(simpleVideoListEntity.getAlbums());

                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }
        });
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        albumGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleAlbumModel> albumModels) {
        if (albumModels==null)
        {

            albumGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        albumGird.onRefreshComplete();
        if (page == 0) {
            albums.clear();
        }
        albums.addAll(albumModels);
        albumAdapter.notifyDataSetChanged();
        albumGird.requestLayout();
    }



}
