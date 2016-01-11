package com.zhanglubao.lol.view.dialog;

import android.app.AlertDialog.Builder;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnClickListener;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListAdapter;

/***
 * IDialog 基本实现
 * @author Rocks
 *
 */
public class DialogImpl implements IDialog{
	
	public Dialog showDialog(Context context, String title, String msg,final DialogCallBack dialogCallBack) {
				Builder builder=	new Builder(context)
				.setTitle(title).setMessage(msg).setNegativeButton("确定", new OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						if(dialogCallBack!=null){
							dialogCallBack.onClick(IDialog.YES);
						}
					}
				});
				if(dialogCallBack!=null){
					builder.setPositiveButton("取消", new OnClickListener() {
						@Override
						public void onClick(DialogInterface dialog, int which) {
							if(dialogCallBack!=null){
								dialogCallBack.onClick(IDialog.CANCLE);
							}
						}
					});
				}
				
		return	builder.show();
	}
	
	public Dialog showItemDialog(Context context, String title,
			CharSequence[] items,final DialogCallBack callback) {
		Dialog	dialog=	
		new Builder(context)
		.setTitle(title).setItems(items, new OnClickListener(){
			
			public void onClick(DialogInterface dialog, int which) {
				if(callback!=null){
					callback.onClick(which);
				}
			}
		}).show();
		return	dialog;
		
	}

	class  DialogOnItemClickListener implements OnItemClickListener{
		Dialog dialog;
		public void setDialog(Dialog dialog){
			this.dialog=dialog;
		}
		
		public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
				long arg3) {
			
		}
		
		
	}
	

	
	public Dialog showProgressDialog(Context context, String title, String msg) {
		ProgressDialog	progressDialog=new ProgressDialog(context);
		progressDialog.setTitle(title);
		progressDialog.setMessage(msg);
		progressDialog.show();
		progressDialog.setCancelable(true);
		return progressDialog;
	}
	
	public Dialog showProgressDialog(Context context, String msg) {
		ProgressDialog	progressDialog=new ProgressDialog(context);
		progressDialog.setMessage(msg);
		progressDialog.show();
		progressDialog.setCancelable(true);
		return progressDialog;
	}
	
	
	public Dialog showProgressDialog(Context context) {
		ProgressDialog	progressDialog=new ProgressDialog(context);
		progressDialog.show();
		progressDialog.setCancelable(true);
		return progressDialog;
	}

	
	public void showToastLong(Context context, String msg) {

	}


	public void showToastShort(Context context, String msg) {

	}

	public void showToastType(Context context, String msg, String type) {
		showToastLong(context, msg);
	}




	public Dialog showDialog(Context context, int icon, String title, String msg,
			DialogCallBack callback) {
		return showDialog(context, title, msg, callback);
	}




	public Dialog showAdapterDialoge(Context context,String title, ListAdapter adapter,
			OnItemClickListener itemClickListener) {
//		Dialog dialog=new ListDialog(context, title, adapter, itemClickListener);
//		dialog.show();
		return null;
	}
}
