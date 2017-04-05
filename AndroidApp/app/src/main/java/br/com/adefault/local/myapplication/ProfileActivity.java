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
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import br.com.adefault.local.myapplication.models.Person;
import br.com.adefault.local.myapplication.models.User;
import br.com.adefault.local.myapplication.utils.Callback;
import br.com.adefault.local.myapplication.utils.PostRequest;
import br.com.adefault.local.myapplication.utils.RequestConf;
import br.com.adefault.local.myapplication.utils.Utils;

public class ProfileActivity extends AppCompatActivity {

    private Context cx;
    private User user;
    private Person person;

    private View mProgressView;
    private View mProfileFormView;

    private TextView profile_desperson;
    private TextView profile_user;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        cx = getBaseContext();

        user = new User(cx);
        person = user.getPerson();

        mProgressView = findViewById(R.id.profile_progress);
        mProfileFormView = findViewById(R.id.user_profile_form);

        profile_desperson = (TextView)findViewById(R.id.profile_desperson);
        profile_user = (TextView)findViewById(R.id.profile_user);

        profile_desperson.setText(person.getDesperson());
        profile_user.setText(user.getDesuser());

        Button btnSave = (Button)findViewById(R.id.profile_save);

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

            final String desperson = profile_desperson.getText().toString();
            final String desuser = profile_user.getText().toString();

            fields.put("desperson", desperson);
            fields.put("desuser", desuser);

            new PostRequest(cx, RequestConf.SERVER + "/users/" + user.getIduser(), fields, new Callback() {
                @Override
                public void run(Boolean success, JSONObject r) {

                    person.setDesperson(desperson);
                    user.setDesuser(desuser);

                    person.save();
                    user.save();

                    showProgress(false);

                    Toast.makeText(cx, "Dados salvos com sucesso!", Toast.LENGTH_SHORT).show();

                    startActivity(new Intent(cx, MainActivity.class));

                }
            });

        } else {
            Toast.makeText(cx, "Sem conexão com a internet.", Toast.LENGTH_SHORT).show();
        }

    }

    /**
     * Shows the progress UI and hides the login form.
     */
    @TargetApi(Build.VERSION_CODES.HONEYCOMB_MR2)
    private void showProgress(final boolean show) {
        // On Honeycomb MR2 we have the ViewPropertyAnimator APIs, which allow
        // for very easy animations. If available, use these APIs to fade-in
        // the progress spinner.
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB_MR2) {
            int shortAnimTime = getResources().getInteger(android.R.integer.config_shortAnimTime);

            mProfileFormView.setVisibility(show ? View.GONE : View.VISIBLE);
            mProfileFormView.animate().setDuration(shortAnimTime).alpha(
                    show ? 0 : 1).setListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mProfileFormView.setVisibility(show ? View.GONE : View.VISIBLE);
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
            mProfileFormView.setVisibility(show ? View.GONE : View.VISIBLE);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.profile, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_profile_password) {
            startActivity(new Intent(cx, ProfilePasswordActivity.class));
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

}
