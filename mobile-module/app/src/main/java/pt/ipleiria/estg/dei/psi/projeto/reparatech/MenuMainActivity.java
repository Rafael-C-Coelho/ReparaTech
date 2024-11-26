package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.google.android.material.navigation.NavigationView;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private NavigationView navigationView;
    private DrawerLayout drawer;

    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_main);

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
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {

        Fragment fragment = null;

        if (item.getItemId()==R.id.navAcessories) {

            fragment = new AcessoriesListFragment();
            setTitle(item.getTitle());

        } else if (item.getItemId()==R.id.navRepairBookings){

            fragment = new RepairBookingFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navLogin) {
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
        } else if (item.getItemId() == R.id.navSignUp) {
            Intent intent = new Intent(this, RegisterActivity.class);
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
}
