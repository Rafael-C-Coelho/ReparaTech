package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.google.android.material.navigation.NavigationView;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.RepairCategoriesListActivity;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityMenuMainBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.LoginListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.RegisterListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Auth;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.utils.MqttManager;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener, LoginListener, RegisterListener {

    private NavigationView navigationView;
    private DrawerLayout drawer;
    private ActivityMenuMainBinding binding;
    private FragmentManager fragmentManager;
    MqttManager mqttManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityMenuMainBinding.inflate(getLayoutInflater());
        setContentView(R.layout.activity_menu_main);

        if (ReparaTechSingleton.getInstance(this).getAuth() != null) {
            Auth auth = ReparaTechSingleton.getInstance(this).getAuth();
            mqttManager = new MqttManager(this, "tcp://test.mosquitto.org:1883", auth.getEmail());
            Toast.makeText(this, "Welcome " + auth.getEmail(), Toast.LENGTH_SHORT).show();
        }

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        drawer = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navBarView);

        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this,
                drawer, toolbar, R.string.ndOpen, R.string.ndClose);
        toggle.syncState();
        drawer.addDrawerListener(toggle);

        navigationView.setNavigationItemSelectedListener(this);

        fragmentManager = getSupportFragmentManager();

        ReparaTechSingleton.getInstance(this).setLoginListener(this);
        ReparaTechSingleton.getInstance(this).setRegisterListener(this);
        onValidateLogin(ReparaTechSingleton.getInstance(this).isLogged(), ReparaTechSingleton.getInstance(this).getRole());

        loadInitialFragment();
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;
        if(item.getItemId()==R.id.navHomepage){
            String role = ReparaTechSingleton.getInstance(this).getRole();
            if ("client".equals(role)) {
                fragment = new HomepageFragment();
            } else {
                fragment = new EmployeeHomepageFragment();
            }
            setTitle(item.getTitle());

        } else if (item.getItemId() == R.id.navProducts) {
            fragment = new ProductsListFragment();
            setTitle(item.getTitle());

        } else if (item.getItemId() == R.id.navRepairBookings) {
            Intent intent = new Intent(this, RepairBookingActivity.class);
            if (!ReparaTechSingleton.getInstance(this).getRole().equals("client")) {
                intent = new Intent(this, RepairBookingActivity.class);
            }
            startActivity(intent);

        } else if (item.getItemId() == R.id.navListRepairCategories) {
            Intent intent = new Intent( this, RepairCategoriesListActivity.class);
            startActivity(intent);

        } else if (item.getItemId() == R.id.navLogin) {
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
        } else if (item.getItemId() == R.id.navUrl) {
            Intent intent = new Intent(this, ServerSettingsActivity.class);
            intent.putExtra(ServerSettingsActivity.ACTION, ServerSettingsActivity.EDIT_ACTION);
            startActivity(intent);
        } else if (item.getItemId() == R.id.navSignUp) {
            Intent intent = new Intent(this, RegisterActivity.class);
            startActivity(intent);
        } else if (item.getItemId() == R.id.navSignOut) {
            ReparaTechSingleton.getInstance(this).removeAuth();
            onValidateLogin(false, "");
        } else if (item.getItemId() == R.id.navCart) {
            Intent intent = new Intent(this, CartActivity.class);
            startActivity(intent);
        }


        if (fragment != null) {
            fragmentManager.beginTransaction().replace(R.id.contentfragment, fragment).commit();
        }

        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    private void loadInitialFragment() {
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setCheckable(true);
        onNavigationItemSelected(item);
    }

    @Override
    public void onValidateLogin(boolean isValid, String role) {
        Menu menu = navigationView.getMenu();

        // Hide/show login-related menu items based on login state
        if (role.isEmpty()) {
            menu.findItem(R.id.navHomepage).setVisible(true);
            menu.findItem(R.id.navRepairBookings).setVisible(false);
            menu.findItem(R.id.navListRepairCategories).setVisible(true);
            menu.findItem(R.id.navProducts).setVisible(true);
            menu.findItem(R.id.navCart).setVisible(false);
        } else if (!role.equals("client")) {
            menu.findItem(R.id.navHomepage).setVisible(true);
            menu.findItem(R.id.navRepairBookings).setVisible(true);
            menu.findItem(R.id.navListRepairs).setVisible(true);
            menu.findItem(R.id.navListRepairCategories).setVisible(false);
            menu.findItem(R.id.navProducts).setVisible(false);
            menu.findItem(R.id.navCart).setVisible(false);
        } else if (role.equals("client")) {
            menu.findItem(R.id.navRepairBookings).setVisible(true);
            menu.findItem(R.id.navListRepairCategories).setVisible(true);
            menu.findItem(R.id.navProducts).setVisible(true);
            menu.findItem(R.id.navCart).setVisible(true);
        }

        menu.findItem(R.id.navLogin).setVisible(!isValid);
        menu.findItem(R.id.navSignUp).setVisible(!isValid);
        menu.findItem(R.id.navSignOut).setVisible(isValid);

        navigationView.invalidate();
    }

    @Override
    public void onValidateRegister(boolean isValid) {
        if (isValid) {
            Toast.makeText(this, R.string.register_successful_verify_your_email, Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(this, R.string.register_failed, Toast.LENGTH_SHORT).show();
        }
    }
}
