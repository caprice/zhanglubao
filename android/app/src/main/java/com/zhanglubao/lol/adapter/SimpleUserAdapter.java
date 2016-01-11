package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.util.NetworkUtils;

import java.util.List;

/**
 * Created by rocks on 15-5-30.
 */
public class SimpleUserAdapter extends BaseAdapter {
    List<SimpleUserModel> users;
    Context context;


    private DisplayImageOptions options;
    private LayoutInflater inflater;

    public SimpleUserAdapter(Context context, List<SimpleUserModel> users) {
        this.context = context;
        this.users = users;
        inflater = LayoutInflater.from(context);
        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_user_avatar)
                .showImageForEmptyUri(R.drawable.default_user_avatar)
                .showImageOnFail(R.drawable.default_user_avatar)
                .displayer(new RoundedBitmapDisplayer(6))
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return users.size();
    }

    @Override
    public Object getItem(int position) {
        return users.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        SimpleUserModel user = users.get(position);
        final ViewHolder holder;
        View view = convertView;
        if (view == null) {
            view = inflater.inflate(R.layout.item_user_simple_grid, null);
            holder = new ViewHolder();
            holder.avatarView = (ImageView) view.findViewById(R.id.userAvatar);
            holder.userNameTextView = (TextView) view.findViewById(R.id.userName);
            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }

        ImageLoader.getInstance().displayImage(user.getAvatar(),
                holder.avatarView, options);
        holder.userNameTextView.setText(user.getNickname());
        view.setOnClickListener(new ItemClickListener(user));
        return view;
    }

    static class ViewHolder {
        ImageView avatarView;
        TextView userNameTextView;
    }


    class ItemClickListener implements View.OnClickListener {
        SimpleUserModel userModel;

        public ItemClickListener(SimpleUserModel userModel) {
            this.userModel = userModel;
        }

        @Override
        public void onClick(View v) {
            if (NetworkUtils.isNetworkAvailable()) {
                String url = QTUrl.video_user_list + userModel.getUid();
                Intent intent = new Intent(context, VideoGridActivity_.class);
                intent.putExtra("title", userModel.getNickname());
                intent.putExtra("url", url);
                context.startActivity(intent);
            }
        }
    }


}
