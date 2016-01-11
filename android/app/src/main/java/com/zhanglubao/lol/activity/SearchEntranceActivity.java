package com.zhanglubao.lol.activity;


import android.content.Intent;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.inputmethod.EditorInfo;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;

import com.zhanglubao.lol.R;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

/**
 * Created by rocks on 15-7-10.
 */
@EActivity(R.layout.activity_search_entrance)
public class SearchEntranceActivity extends BaseFragmentActivity  implements OnEditorActionListener{

    @ViewById(R.id.searchEditText)
    EditText editText;
    @ViewById(R.id.search_button)
    Button searchButton;
    String keyword = "";

    @AfterViews
    public void afterView() {
        editText.setFocusable(true);
        editText.addTextChangedListener(textWatcher);
        editText.setOnEditorActionListener(this);
    }

    TextWatcher textWatcher = new TextWatcher() {
        @Override
        public void beforeTextChanged(CharSequence s, int start, int count, int after) {

        }

        @Override
        public void onTextChanged(CharSequence s, int start, int before, int count) {

        }

        @Override
        public void afterTextChanged(Editable s) {
            keyword = s.toString().trim();
            if (keyword.length() > 0) {
                searchButton.setText(getString(R.string.search_btn));
            } else {
                searchButton.setText(getString(R.string.search_btn));
            }
        }
    };

    @Click(R.id.search_button)
    public void search() {
        if (keyword.length() > 0) {
            Intent intent = new Intent(this, SearchActivity_.class);
            intent.putExtra("keyword", keyword);
            startActivity(intent);
            finish();
        } else {
            finish();
        }
    }

    @Override
    public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
        switch(actionId){
            case EditorInfo.IME_ACTION_SEARCH:
                 search();
                break;
        }

        return true;
    }
}
