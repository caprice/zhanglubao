package com.zhanglubao.lol.fragment;

import android.content.Intent;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.PlayerActivity_;
import com.zhanglubao.lol.adapter.CachedVideoAdapter;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.downloader.DownloadManager;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Iterator;
import java.util.Map;

/**
 * Created by rocks on 15-6-26.
 */
@EFragment(R.layout.fragment_cached)
public class CachedFragment extends BaseFragment {
    @ViewById(R.id.list_view)
    ListView listView;
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.cache_edit)
    TextView editButton;
    @ViewById(R.id.cache_layout)
    View cacheLayout;

    private CachedVideoAdapter adapter;
    private DownloadManager download;

    private boolean needwait = true;
    private ArrayList<DownloadInfo> infos = new ArrayList<DownloadInfo>();
    private ArrayList<DownloadInfo> delInfos = new ArrayList<DownloadInfo>();
    public static boolean mIsEditState = false;

    public static CachedFragment newInstance() {
        CachedFragment fragment = new CachedFragment_();
        return fragment;
    }

    private Handler handler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            initData();
            if (adapter == null) {
                adapter = new CachedVideoAdapter(getActivity(), infos);
                listView.setAdapter(adapter);
            } else {
                adapter.setData(infos);
                adapter.notifyDataSetChanged();
            }
        }

    };

    @AfterViews
    public void afterView() {
        download = DownloadManager.getInstance();
        adapter = new CachedVideoAdapter(getActivity(), infos);
        listView.setAdapter(adapter);
        listView.setOnItemClickListener(listener);

    }

    private void initData() {
        Iterator iter = download.getDownloadedData().entrySet().iterator(); // 获得map的Iterator
        infos.clear();
        while (iter.hasNext()) {
            Map.Entry entry = (Map.Entry) iter.next();
            DownloadInfo info = (DownloadInfo) entry.getValue();
            ArrayList<DownloadInfo> downloadInfos = new ArrayList<DownloadInfo>();
            downloadInfos.add(info);
            infos.add(info);
        }

        DownloadInfo.compareBySeq = false;
        Collections.sort(infos);
        loadCompelete();
    }

    public void loadCompelete() {
        loadingBar.setVisibility(View.GONE);
        if (infos != null && infos.size() > 0) {
            cacheLayout.setVisibility(View.VISIBLE);
        } else {
            cacheLayout.setVisibility(View.GONE);
        }
    }


    private AdapterView.OnItemClickListener listener = new AdapterView.OnItemClickListener() {

        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position,
                                long id) {
            DownloadInfo info = (DownloadInfo) parent.getAdapter().getItem(position);
            if (mIsEditState) {
                ImageView imageView = (ImageView) listView.findViewWithTag("cached_" + info.videoid);
                if (imageView == null) {
                    return;
                }
                if (delInfos.contains(info)) {
                    delInfos.remove(info);
                    imageView.setImageResource(R.drawable.edit_unselected);
                } else {
                    delInfos.add(info);
                    imageView.setImageResource(R.drawable.edit_selected);
                }
            } else {

                Intent intent = new Intent(getActivity(), PlayerActivity_.class);
                intent.putExtra("info", info);
                startActivity(intent);
            }
        }

    };

    @Override
    public void onResume() {
        if (needwait) {
            handler.sendEmptyMessageDelayed(0, 100L);
            needwait = false;
        } else
            handler.sendEmptyMessage(0);
        super.onResume();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        mIsEditState = false;
    }

    public void notifyData() {
        delInfos.clear();
        for (DownloadInfo item : infos) {
            item.iseditState = 0;
        }
        if (adapter != null) {
            adapter.notifyDataSetChanged();
        }
    }

    public void refresh() {
        handler.sendEmptyMessageDelayed(0, 500L);
    }


    @ViewById(R.id.bottom_area)
    View bottomArea;

    boolean isSelectAll = false;
    @ViewById(R.id.btn_all_select)
    TextView allSelectView;

    @Click(R.id.btn_all_select)
    public void selectAll() {
        if (!isSelectAll) {
            delInfos = infos;
            for (DownloadInfo info : infos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("cached_" + info.videoid);
                imageView.setImageResource(R.drawable.edit_selected);
            }
            allSelectView.setText(getString(R.string.all_unselect));
            isSelectAll = true;
        } else {
            isSelectAll = false;
            delInfos = new ArrayList<>();
            for (DownloadInfo info : infos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("cached_" + info.videoid);
                imageView.setImageResource(R.drawable.edit_unselected);
            }
            allSelectView.setText(getString(R.string.all_select));
        }
    }

    @Click(R.id.cache_edit)
    public void edit() {
        if (mIsEditState) {
            mIsEditState = false;
            delInfos.clear();
            bottomArea.setVisibility(View.GONE);
            editButton.setText(getResources().getString(R.string.edit));
            adapter.notifyDataSetChanged();
        } else {
            mIsEditState = true;
            bottomArea.setVisibility(View.VISIBLE);
            editButton.setText(getResources().getString(R.string.finish));
            adapter.notifyDataSetChanged();
        }
        loadCompelete();
    }

    @Click(R.id.btn_del_select)
    public void delInfos() {
        ArrayList<DownloadInfo> temps = new ArrayList<>();
        for (DownloadInfo info : delInfos) {
            if (infos.contains(info)) {
                temps.add(info);
            }

        }
        delSelects(temps);
        infos.removeAll(temps);
        adapter = new CachedVideoAdapter(getActivity(), infos);
        listView.setAdapter(adapter);
        edit();
    }
    @Background
    public  void delSelects(ArrayList<DownloadInfo> delItems)
    {
        if (delItems!=null&&delItems.size()>0) {
            download.deleteDownloadeds(delItems);
        }
    }


}
