package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.OrderListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class OrderListFragment extends Fragment {

    private ListView lvOrders;
    private ArrayList<Order> orders;

    private SearchView searchView;
    private OrderListAdapter adapter;
    private SwipeRefreshLayout swipeRefreshLayout;

    public OrderListFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view = inflater.inflate(R.layout.fragment_order_list, container, false);

        setHasOptionsMenu(true);

        lvOrders = view.findViewById(R.id.LvOrders);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layout);
        //swipeRefreshLayout.setOnRefreshListener(this::onRefresh);

        orders = new ArrayList<>();
        adapter = new OrderListAdapter(getContext(), orders);
        lvOrders.setAdapter(adapter);

        lvOrders.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(getContext(), OrderDetailActivity.class);
                intent.putExtra(OrderDetailActivity.ID_ORDER, (int) id);
                startActivity(intent);
            }
        });

        return inflater.inflate(R.layout.fragment_order_list, container, false);
    }

}