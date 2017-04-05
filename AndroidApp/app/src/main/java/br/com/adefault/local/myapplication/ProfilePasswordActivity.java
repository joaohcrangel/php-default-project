package br.com.adefault.local.myapplication;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import br.com.adefault.local.myapplication.models.Person;
import br.com.adefault.local.myapplication.models.User;
import br.com.adefault.local.myapplication.utils.Callback;
import br.com.adefault.local.myapplication.utils.PostRequest;
import br.com.adefault.local.myapplication.utils.RequestConf;
import br.com.adefault.local.myapplication.utils.Utils;

public class ProfilePasswordActivity extends AppCompatActivity {

    private Context cx;
    private User user;
    private Person person;

    private View mProgressView;
    private View mFormView;

    private TextView currentPassword;
    private TextView newPassword;
    private TextView repeatPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        cx = getBaseContext();

        user = new User(cx);
        person = user.getPerson();

        setContentView(R.layout.activity_profile_password);

        mProgressView = findViewById(R.id.profile_password_progress);
        mFormView = findViewById(R.id.user_profile_password_form);

        currentPassword = (TextView)findViewById(R.id.profile_password_current);
        newPassword = (TextView)findViewById(R.id.profile_password_new);
        repeatPassword = (TextView)findViewById(R.id.profile_password_repeat);

        Button btnSave = (Button)findViewById(R.id.profile_password_save);

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                save();

            }
        });

    }

    private void save() {

        if (Utils.isOnline(cx)) {

            showProgress(true);

            Map<String,String> fields = new HashMap<String,String>();

            final String current_pass = currentPassword.getText().toString();
            final String new_pass = newPassword.getText().toString();
            final String repeat_pass = repeatPassword.getText().toString();

            fields.put("passwordnew", new_pass);
            fields.put("passwordcurrent", current_pass);
            fields.put("passwordconfirm", repeat_pass);

            new PostRequest(cx, RequestConf.SERVER + "/users/" + user.getIduser() + "/password", fields, new Callback() {
                @Override
                public void run(Boolean success, JSONObject r) {

                    showProgress(false);

                    if (success) {
                        try {

                            JSONObject data = r.getJSONObject("data");
                            String despassword = data.getString("despassword");

                            user.setDespassword(despassword);

                            user.save();

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                        Toast.makeText(cx, "Senha alterada com sucesso!", Toast.LENGTH_SHORT).show();

                        startActivity(new Intent(cx, MainActivity.class));

                    } else {

                        try {
                            String error = r.getString("error");
                            Toast.makeText(cx, error, Toast.LENGTH_SHORT).show();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }

                }
            });

        } else {
            Toast.makeText(cx, "Sem conexão com a internet.", Toast.LENGTH_SHORT).show();
        }

    }

    @TargetApi(Build.VERSION_CODES.HONEYCOMB_MR2)
    private void showProgress(final boolean show) {
        // On Honeycomb MR2 we have the ViewPropertyAnimator APIs, which allow
        // for very easy animations. If available, use these APIs to fade-in
        // the progress spinner.
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB_MR2) {
            int shortAnimTime = getResources().getInteger(android.R.integer.config_shortAnimTime);

            mFormView.setVisibility(show ? View.GONE : View.VISIBLE);
            mFormView.animate().setDuration(shortAnimTime).alpha(
                    show ? 0 : 1).setListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mFormView.setVisibility(show ? View.GONE : View.VISIBLE);
                }
            });

            mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);
            mProgressView.animate().setDuration(shortAnimTime).alpha(
                    show ? 1 : 0).setListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);
                }
            });
        } else {
            // The ViewPropertyAnimator APIs are not available, so simply show
            // and hide the relevant UI components.
            mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);
            mFormView.setVisibility(show ? View.GONE : View.VISIBLE);
        }
    }

}
