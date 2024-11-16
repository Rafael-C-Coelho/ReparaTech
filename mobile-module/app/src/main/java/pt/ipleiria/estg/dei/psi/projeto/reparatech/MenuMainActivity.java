package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.view.Gravity;
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

import java.sql.SQLOutput;

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
        }

        if (fragment != null) {
            fragmentManager.beginTransaction().replace(R.id.contentfragment, fragment).commit();
        }

        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    private void carregarFragmentoInicial() { //exercício 9.1 ficha 4
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setCheckable(true);
        onNavigationItemSelected(item);
    }
}
