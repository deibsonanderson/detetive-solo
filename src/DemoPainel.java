import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.util.ArrayList;

import javax.swing.JPanel;

public class DemoPainel extends JPanel {

	
	private static final long serialVersionUID = 2868133180133666012L;
	// SCREEN SETTINGS
	final int maxCol = 25;
	final int maxRow = 25;
	final int nodeSize = 30;
	final int screenWidth = nodeSize * maxCol;
	final int screenHeight = nodeSize * maxRow;

	// NODE
	Node[][] node = new Node[maxCol][maxRow];
	Node startNode, goalNode, currentNode;
	ArrayList<Node> openList = new ArrayList<>();
	ArrayList<Node> checkedList = new ArrayList<>();

	//outros
	boolean goalReached = false;
	int step = 0;

	public DemoPainel() {
		this.setPreferredSize(new Dimension(screenWidth, screenHeight));
		this.setBackground(Color.black);
		this.setLayout(new GridLayout(maxRow, maxCol));
		this.addKeyListener(new KeyHandler(this));
		this.setFocusable(true);
		
		int col = 0;
		int row = 0;

		while (col < maxCol && row < maxRow) {
			node[col][row] = new Node(col, row);
			this.add(node[col][row]);

			col++;
			if (col == maxCol) {
				col = 0;
				row++;
			}
		}

		setStartNode(3, 6);
		setGoalNode(11, 3);

		
		setSolidNode(6, 0);
		
		setSolidNode(10, 2);
		setSolidNode(10, 3);
		setSolidNode(10, 4);
		setSolidNode(10, 5);
		setSolidNode(10, 6);
		setSolidNode(10, 7);
		setSolidNode(6, 2);
		setSolidNode(7, 2);
		setSolidNode(8, 2);
		setSolidNode(9, 2);
		setSolidNode(11, 7);
		setSolidNode(12, 7);
		setSolidNode(6, 1);

		setCostOnNodes();

	}

	private void setStartNode(int col, int row) {
		node[col][row].setAsStart();
		startNode = node[col][row];
		currentNode = startNode;
	}

	private void setGoalNode(int col, int row) {
		node[col][row].setAsGoal();
		goalNode = node[col][row];
	}

	private void setSolidNode(int col, int row) {
		node[col][row].setAsSolid();
	}

	private void setCostOnNodes() {
		int col = 0;
		int row = 0;
		getCost(node[col][row]);
		while (col < maxCol && row < maxRow) {
			getCost(node[col][row]);
			col++;
			if (col == maxCol) {
				col = 0;
				row++;
			}
		}

	}

	private void getCost(Node node) {

		// G COST a distancia do start
		int xDistante = Math.abs(node.col - startNode.col);
		int yDistante = Math.abs(node.row - startNode.row);
		node.gCost = xDistante + yDistante;

		// H COST a distancia do goal
		xDistante = Math.abs(node.col - goalNode.col);
		yDistante = Math.abs(node.row - goalNode.row);
		node.hCost = xDistante + yDistante;

		// total
		node.fCost = node.gCost + node.hCost;

		// exibir o custo dos nos
		if (node != startNode && node != goalNode) {
			node.setText("<html>F:" + node.fCost + "<br>G:" + node.gCost + "</html>");
		}
	}

	public void search() {
		if (goalReached == false && step < 300) {
			int col = currentNode.col;
			int row = currentNode.row;

			currentNode.setAsChecked();
			checkedList.add(currentNode);
			openList.remove(currentNode);

			// open up
			if (row -1 >= 0) {
				openNode(node[col][row-1]);
			}
			// open left
			if (col -1 >= 0) {
				openNode(node[col-1][row]);
			}
			// open down
			if (row +1 < maxRow) {
				openNode(node[col][row+1]);
			}
			// open right
			if (row +1 < maxCol) {
				openNode(node[col+1][row]);
			}
			
			
			//encontrar o melhor no
			int bestNodeIndex = 0;
			int bestNodefCost = 999;
			
			for (int i = 0; i < openList.size(); i++) {
				//checa se os nos f cost é melhor
				if(openList.get(i).fCost < bestNodefCost) {
					bestNodeIndex = i;
					bestNodefCost = openList.get(i).fCost;
				}
				//if F cost é igual , checa o g Cost
				else if(openList.get(i).fCost == bestNodefCost) {
					if(openList.get(i).gCost < openList.get(bestNodeIndex).gCost) {
						bestNodeIndex = i;
					}
				}
			}
			
			//depois do loop nos pegamos o melhor nó e escolhemos o seu proximo passo
			currentNode = openList.get(bestNodeIndex);
			
			if(currentNode == goalNode) {
				goalReached = true;
			}
		}
		step++;
	}
	
	public void autoSearch() {
		while (goalReached == false) {
			int col = currentNode.col;
			int row = currentNode.row;

			currentNode.setAsChecked();
			checkedList.add(currentNode);
			openList.remove(currentNode);

			// open up
			if (row -1 >= 0) {
				openNode(node[col][row-1]);
			}
			// open left
			if (col -1 >= 0) {
				openNode(node[col-1][row]);
			}
			// open down
			if (row +1 < maxRow) {
				openNode(node[col][row+1]);
			}
			// open right
			if (row +1 < maxCol) {
				openNode(node[col+1][row]);
			}
			
			
			//encontrar o melhor no
			int bestNodeIndex = 0;
			int bestNodefCost = 999;
			
			for (int i = 0; i < openList.size(); i++) {
				//checa se os nos f cost é melhor
				if(openList.get(i).fCost < bestNodefCost) {
					bestNodeIndex = i;
					bestNodefCost = openList.get(i).fCost;
				}
				//if F cost é igual , checa o g Cost
				else if(openList.get(i).fCost == bestNodefCost) {
					if(openList.get(i).gCost < openList.get(bestNodeIndex).gCost) {
						bestNodeIndex = i;
					}
				}
			}
			
			//depois do loop nos pegamos o melhor nó e escolhemos o seu proximo passo
			currentNode = openList.get(bestNodeIndex);
			
			if(currentNode == goalNode) {
				goalReached = true;
				trackThePatch();
			}
		}
	}

	private void openNode(Node node) {
		if (node.open == false && node.checked == false && node.solid == false) {
			node.setAsOpen();
			node.parent = currentNode;
			openList.add(node);
		}
	}
	
	private void trackThePatch() {
		Node current = goalNode;
		
		while(current != startNode) {
			current = current.parent;
			
			if(current != startNode) {
				current.setAsPath();
			}
		}
	}

}
