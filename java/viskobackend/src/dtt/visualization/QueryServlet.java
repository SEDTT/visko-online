package dtt.visualization;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.gson.Gson;

import dtt.JsonServlet;
import dtt.visualization.json.GsonFactory;
import edu.utep.trustlab.visko.planning.Query;

/**
 * Servlet implementation class QueryServlet
 */
@WebServlet("/query")
public class QueryServlet extends JsonServlet {
	private int count = 0;
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public QueryServlet() {
        super();
        // TODO Auto-generated constructor stub
    }

	@Override
	protected void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		PrintWriter out = response.getWriter();
		GsonFactory gfact = new GsonFactory();
		Gson gson = gfact.makeGson();
		String id = request.getParameter("id");
		out.println(gson.toJson(new Query(id + "This is a fake query" + count++)));
		out.flush();
		
	}

}
