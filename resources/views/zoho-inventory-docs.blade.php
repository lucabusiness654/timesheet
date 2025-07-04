<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoho Inventory Order Flow Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
            --info: #1abc9c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary);
            position: relative;
            padding-bottom: 15px;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: linear-gradient(to right, var(--secondary), var(--info));
        }
        
        .flow-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .flow-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .section-header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
        }
        
        .section-header i {
            transition: transform 0.3s ease;
        }
        
        .section-header.active i {
            transform: rotate(180deg);
        }
        
        .flow-container {
            display: none;
            padding: 20px;
        }
        
        .flow-container.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .flow-diagram {
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .flow-step {
            display: flex;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .flow-step:last-child {
            margin-bottom: 0;
        }
        
        .admin-action {
            flex: 1;
            padding: 15px;
            background-color: var(--light);
            border-radius: 8px;
            margin-right: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease;
            border-left: 4px solid var(--secondary);
        }
        
        .admin-action:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .zoho-action {
            flex: 2;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease;
            border-left: 4px solid var(--info);
        }
        
        .zoho-action:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .action-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .action-title {
            font-weight: 600;
            color: var(--dark);
        }
        
        .action-status {
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-closed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-rto {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .action-details {
            font-size: 0.9rem;
            color: #666;
            margin-top: 10px;
            display: none;
        }
        
        .action-details.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 500px; }
        }
        
        .toggle-details {
            background: none;
            border: none;
            color: var(--secondary);
            cursor: pointer;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .toggle-details i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .toggle-details.active i {
            transform: rotate(180deg);
        }
        
        .connector {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--secondary);
            z-index: -1;
            transform: translateX(-50%);
        }
        
        .connector-dot {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 10px;
            height: 10px;
            background-color: var(--secondary);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        
        .notes {
            background-color: #f8f9fa;
            border-left: 4px solid var(--warning);
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        
        .notes-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .notes-content {
            font-size: 0.9rem;
            color: #666;
        }
        
        .flow-legend {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            margin: 0 10px;
            font-size: 0.9rem;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
            margin-right: 5px;
        }
        
        .color-admin {
            background-color: var(--light);
            border-left: 4px solid var(--secondary);
        }
        
        .color-zoho {
            background-color: white;
            border-left: 4px solid var(--info);
        }
        
        .color-notes {
            background-color: #f8f9fa;
            border-left: 4px solid var(--warning);
        }
        
        @media (max-width: 768px) {
            .flow-step {
                flex-direction: column;
            }
            
            .admin-action, .zoho-action {
                margin-right: 0;
                margin-bottom: 15px;
                width: 100%;
            }
            
            .connector {
                left: 20px;
                top: 50%;
                bottom: auto;
                height: 15px;
                width: 2px;
            }
            
            .connector-dot {
                left: 20px;
                top: 50%;
            }
        }
        
        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
        }
        
        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        
        /* Animation for important notes */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }
        
        .important-note {
            background-color: #f8d7da;
            border-left: 4px solid var(--danger);
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            animation: pulse 2s infinite;
        }
        
        .important-note-title {
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 10px;
        }

        .requirements-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 25px;
        }
        
        .requirements-header {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary);
            position: relative;
            padding-bottom: 15px;
        }
        
        .requirements-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: linear-gradient(to right, var(--secondary), var(--info));
        }
        
        .requirements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .requirement-card {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--info);
        }
        
        .requirement-card h3 {
            color: var(--primary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .requirement-card h3 i {
            margin-right: 10px;
        }
        
        .requirement-card ul {
            padding-left: 20px;
        }
        
        .requirement-card li {
            margin-bottom: 8px;
        }
        
        .status-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .status-table th, .status-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .status-table th {
            background-color: var(--primary);
            color: white;
        }
        
        .status-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .status-table tr:hover {
            background-color: #ddd;
        }
        
        .emoji {
            font-size: 1.2em;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="requirements-section">
    <div class="requirements-header">
        <h2><i class="fas fa-clipboard-list"></i> Zoho Inventory Integration Requirements</h2>
    </div>
    
    <div class="requirements-content">
        <div class="requirement-block">
            <h3><span class="emoji">✅</span> 1. Client Requirement</h3>
            <p>We need to track all movements of products — including orders, returns, and exchanges. This includes:</p>
            <ul>
                <li>Customer orders, with return or exchange data</li>
                <li>Internal stock transfers, such as sending stock to an Expo and receiving returns</li>
            </ul>
            
            <h4><span class="emoji">📌</span> Key Needs:</h4>
            <ul>
                <li>Track how much stock is going from one location to another</li>
                <li>Track how much is returned (e.g., unsold items from Expo)</li>
                <li>Track item-level information, including quantity and descriptions</li>
            </ul>
            
            <h4><span class="emoji">🎯</span> Locations Involved:</h4>
            <ul>
                <li>Main Warehouse (central e-commerce stock)</li>
                <li>Expo / Event Locations (temporary transfers)</li>
            </ul>
        </div>
        
        <div class="requirement-block">
            <h3><span class="emoji">🧠</span> 2. Idea of How Zoho Inventory Works</h3>
            <p>Zoho Inventory provides key features we can leverage:</p>
            
            <table class="status-table">
                <tr>
                    <th>Zoho Feature</th>
                    <th>Purpose</th>
                </tr>
                <tr>
                    <td>Transfer Orders</td>
                    <td>Move stock between internal warehouses (e.g., Main to Expo)</td>
                </tr>
                <tr>
                    <td>Invoices + Sales Returns</td>
                    <td>Record actual sales and return of purchased items</td>
                </tr>
            </table>
        </div>
        
        <div class="requirement-block">
            <h3><span class="emoji">🚀</span> 3. How We're Going to Proceed</h3>
            <p>We will develop a Zoho Inventory Module in our Admin Panel with the following features:</p>
            
            <h4><span class="emoji">🔄</span> 1. Product Sync</h4>
            <p>Sync products from our system to Zoho (manual & cron support)</p>
            
            <h4><span class="emoji">📦</span> 2. Order Sync</h4>
            <p>Sync customer orders (with return/exchange info) to Zoho</p>
            <p>This will be manual initially</p>
            
            <h4><span class="emoji">🔁</span> 3. Transfer Orders</h4>
            <p>Handle internal transfers to/from Expo and other locations</p>
            <p>Track full flow: Sent → Received → Returned</p>
            <p>Include item details, descriptions, and status</p>
        </div>
        
        <div class="requirement-block">
            <h3><span class="emoji">⚠️</span> 4. Things to Note About Zoho Inventory</h3>
            
            <h4><span class="emoji">🛡️</span> API Call Limits</h4>
            <p>Zoho enforces rate limits to ensure fair usage across users.</p>
            
            <table class="status-table">
                <tr>
                    <th>Plan Type</th>
                    <th>API Calls per Minute</th>
                    <th>API Calls per Day</th>
                </tr>
                <tr>
                    <td>Free Plan</td>
                    <td>100/min</td>
                    <td>1,500/day</td>
                </tr>
                <tr>
                    <td>Standard Plan</td>
                    <td>100/min</td>
                    <td>2,500/day</td>
                </tr>
                <tr>
                    <td>Professional</td>
                    <td>100/min</td>
                    <td>5,000/day</td>
                </tr>
                <tr>
                    <td>Premium</td>
                    <td>100/min</td>
                    <td>7,500/day</td>
                </tr>
                <tr>
                    <td>Enterprise</td>
                    <td>100/min</td>
                    <td>10,000/day</td>
                </tr>
            </table>
            
            <p><span class="emoji">⚠️</span> If you exceed limits, you'll get a 429 Too Many Requests error.</p>
            
            <h4><span class="emoji">⚙️</span> Concurrent Rate Limiter</h4>
            <p>Zoho limits how many simultaneous API calls can be made at a time:</p>
            
            <table class="status-table">
                <tr>
                    <th>Plan Type</th>
                    <th>Max Concurrent Calls</th>
                </tr>
                <tr>
                    <td>Free Plan</td>
                    <td>5 concurrent requests</td>
                </tr>
                <tr>
                    <td>Paid Plans</td>
                    <td>10 concurrent requests (soft limit)</td>
                </tr>
            </table>
            
            <p>If you exceed this, Zoho will return an error:</p>
            <pre>HTTP 429 - Concurrent limit exceeded</pre>
            <p><span class="emoji">💡</span> Best Practice: Use queueing or job dispatching to limit concurrent requests.</p>
            
            <h4><span class="emoji">🛠️</span> Configuration Required</h4>
            <p>To make the Zoho Inventory integration work, we must configure the following:</p>
            
            <table class="status-table">
                <tr>
                    <th>Setting</th>
                    <th>Example / Notes</th>
                </tr>
                <tr>
                    <td>Organization ID</td>
                    <td>1234567890 (Required in every API call)</td>
                </tr>
                <tr>
                    <td>OAuth Setup</td>
                    <td>Use client_id, client_secret, and refresh_token to get access_token</td>
                </tr>
                <tr>
                    <td>Warehouse Mapping</td>
                    <td>Link Zoho warehouse IDs to your local system warehouse IDs</td>
                </tr>
            </table>
        </div>
    </div>
</div>
        <h1>Zoho Inventory Order Flow Management</h1>
        
        <div class="flow-legend">
            <div class="legend-item">
                <div class="legend-color color-admin"></div>
                <span>Admin Panel Action</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-zoho"></div>
                <span>Zoho Inventory Action</span>
            </div>
            <div class="legend-item">
                <div class="legend-color color-notes"></div>
                <span>Important Notes</span>
            </div>
        </div>
        
        <div class="important-note">
            <div class="important-note-title"><i class="fas fa-exclamation-circle"></i> Important Restrictions</div>
            <div class="notes-content">
                <ul>
                    <li>Cancel Items Option Only For Before Creating Package</li>
                    <li>Sales order(s) that have been converted to package(s) cannot be deleted</li>
                    <li>Packed sales orders cannot be voided</li>
                    <li>You cannot decline a sales return when there are receives associated with it</li>
                </ul>
            </div>
        </div>
        
        <!-- ORDER FLOW SECTION -->
        <div class="flow-section">
            <div class="section-header">
                <h2><i class="fas fa-shipping-fast"></i> Order Flow Process</h2>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="flow-container">
                <div class="flow-diagram">
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Order Placed</span>
                                <span class="action-status status-pending">REQUESTED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Customer places an order through the system.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Order Accepted</span>
                                <span class="action-status status-confirmed">CONFIRMED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin accepts the order in the admin panel.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Package & Invoice</span>
                                <span class="action-status status-confirmed">PROCESSING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Order appears in Zoho Inventory with status: CONFIRMED.</li>
                                    <li>Create Package Slip</li>
                                    <li>Create invoice (COD/PREPAID)</li>
                                    <li>For PREPAID: Check payment received checkbox</li>
                                    <li>For COD: Invoice remains in Draft status</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Order Shipped</span>
                                <span class="action-status status-pending">SHIPPED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin marks order as shipped in admin panel.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Create Shipment</span>
                                <span class="action-status status-pending">SHIPPED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Create new Shipment</li>
                                    <li>Shipment Type: SHIP MANUALLY</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Out For Delivery</span>
                                <span class="action-status status-pending">IN TRANSIT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin updates status to Out For Delivery.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Update Shipment</span>
                                <span class="action-status status-pending">IN TRANSIT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Update shipment status in Shipment menu to "Out For Delivery".</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Order Delivered</span>
                                <span class="action-status status-closed">DELIVERED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin confirms order delivery in admin panel.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Complete Order</span>
                                <span class="action-status status-closed">CLOSED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Update shipment status in Shipment menu to "Order Delivery"</li>
                                    <li>ORDER STATUS changes to CLOSED</li>
                                    <li>For COD: Record payment received against invoice</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="notes">
                        <div class="notes-title"><i class="fas fa-info-circle"></i> Order Cancel & RTO Notes</div>
                        <div class="notes-content">
                            <p><strong>Order Cancel:</strong> Once order is placed, before creating package, you can use the void option to cancel.</p>
                            <p><strong>RTO Flow:</strong></p>
                            <ul>
                                <li>Change sales order status (custom status) to 'RTO delivered'</li>
                                <li>If COD: Just add stock back (Restock Manually)</li>
                                <li>If Prepaid: Follow return flow process</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- RETURN FLOW SECTION -->
        <div class="flow-section">
            <div class="section-header">
                <h2><i class="fas fa-undo"></i> Return Flow Process</h2>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="flow-container">
                <div class="flow-diagram">
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Return Requested</span>
                                <span class="action-status status-pending">REQUESTED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Customer requests return through system.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Return Accepted</span>
                                <span class="action-status status-pending">ACCEPTED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin accepts the return request.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Create Sales Return</span>
                                <span class="action-status status-pending">PROCESSING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Create sales return in Zoho Inventory.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Pickup Expected</span>
                                <span class="action-status status-pending">SCHEDULED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin schedules pickup for return items.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Refund Initiated</span>
                                <span class="action-status status-pending">PROCESSING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin initiates refund process.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Update Status</span>
                                <span class="action-status status-completed">RECEIVED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Change the status to RECEIVED in Zoho Inventory.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Refund Credited</span>
                                <span class="action-status status-closed">COMPLETED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Refund is credited to customer's account.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Credit & Status Update</span>
                                <span class="action-status status-closed">COMPLETED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Create credit (save as open)</li>
                                    <li>Once received by customer, change to status -> refund status in Zoho Inventory</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="notes">
                        <div class="notes-title"><i class="fas fa-exclamation-triangle"></i> Rejection & Damage Cases</div>
                        <div class="notes-content">
                            <p><strong>Return Rejected:</strong> In Zoho Inventory 'Return Decline' with description</p>
                            <p><strong>Product Received In Damaged State:</strong> In Zoho Inventory 'Return Decline' with description</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- EXCHANGE FLOW SECTION -->
        <div class="flow-section">
            <div class="section-header">
                <h2><i class="fas fa-exchange-alt"></i> Exchange Flow Process</h2>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="flow-container">
                <div class="flow-diagram">
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchange Requested</span>
                                <span class="action-status status-pending">REQUESTED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Customer requests exchange through system.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchange Accepted</span>
                                <span class="action-status status-pending">ACCEPTED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin accepts the exchange request.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Create Sales Return</span>
                                <span class="action-status status-pending">PROCESSING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Create sales return in Zoho Inventory.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Product Pickup</span>
                                <span class="action-status status-pending">IN PROGRESS</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Original product is picked up from customer.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Product Received</span>
                                <span class="action-status status-pending">RECEIVED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Original product is received back at warehouse.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">No Action Needed</span>
                                <span class="action-status status-pending">PENDING</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Zoho Inventory doesn't require any action at this stage.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchanged</span>
                                <span class="action-status status-completed">PROCESSED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Exchange is processed in system.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Complete Exchange</span>
                                <span class="action-status status-completed">PROCESSED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Change the status to RECEIVED</li>
                                    <li>Create credit (save as open) - no need to refund (because this is exchange)</li>
                                    <li>In sales order menu, create new order for replacement product</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchange Order Shipped</span>
                                <span class="action-status status-pending">SHIPPED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Replacement product is shipped to customer.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Package & Invoice</span>
                                <span class="action-status status-pending">SHIPPED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Create Package Slip</li>
                                    <li>Create invoice</li>
                                    <li>Apply Credits (Linked with CREDIT NOTE Transaction#)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchange Out For Delivery</span>
                                <span class="action-status status-pending">IN TRANSIT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Replacement product is out for delivery.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Update Shipment</span>
                                <span class="action-status status-pending">IN TRANSIT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Update shipment status in Shipment menu to "Out For Delivery".</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Exchange Delivered</span>
                                <span class="action-status status-closed">COMPLETED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Replacement product is delivered to customer.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Complete Order</span>
                                <span class="action-status status-closed">CLOSED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Update shipment status in Shipment menu to "Order Delivery" (ORDER STATUS: CLOSED)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DELIVERY CHALLAN FLOW SECTION -->
        <div class="flow-section" style="display: none;">
            <div class="section-header">
                <h2><i class="fas fa-truck-loading"></i> Delivery Challan Flow Process</h2>
                <i class="fas fa-chevron-down"></i>
                            </div>
            <div class="flow-container">
                <div class="flow-diagram">
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Challan Created</span>
                                <span class="action-status status-pending">DRAFT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin creates delivery challan with customer details, items, and type (supply/approval).</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Create Delivery Challan</span>
                                <span class="action-status status-pending">DRAFT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Create delivery challan in Zoho Inventory</li>
                                    <li>Status: DRAFT</li>
                                    <li>Type: Supply of Approval</li>
                                    <li>Add all items being sent</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Challan Converted to Open</span>
                                <span class="action-status status-pending">OPEN</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin converts the challan from draft to open status.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Convert to Open</span>
                                <span class="action-status status-pending">OPEN</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Change delivery challan status from DRAFT to OPEN in Zoho Inventory.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Partial Sales</span>
                                <span class="action-status status-pending">PARTIAL</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Customer purchases some items from the challan.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Generate Invoice</span>
                                <span class="action-status status-pending">PARTIAL</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>For sold items: Generate invoice</li>
                                    <li>Record payment against the invoice</li>
                                    <li>Challan status will show as PARTIAL INVOICE</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Record Returns</span>
                                <span class="action-status status-pending">RETURNED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin records return of unsold items.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Record Partial Returns</span>
                                <span class="action-status status-pending">RETURNED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>For remaining unsold items: Click 'Record Partial Returns' in Zoho Inventory.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>
                    
                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Challan Completed</span>
                                <span class="action-status status-closed">DELIVERED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin marks the entire challan process as completed.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Mark as Delivered</span>
                                <span class="action-status status-closed">DELIVERED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Final step: Mark the delivery challan as DELIVERED in Zoho Inventory.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="notes">
                        <div class="notes-title"><i class="fas fa-info-circle"></i> Delivery Challan Notes</div>
                        <div class="notes-content">
                            <ul>
                                <li>Delivery challans are used for approval/supply processes where items are sent for customer approval before purchase</li>
                                <li>The process allows for partial sales and returns of unsold items</li>
                                <li>Payment is only recorded for items that are actually purchased</li>
                                <li>Inventory is only deducted when items are actually sold (invoice generated)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TRANSFER ORDER FLOW SECTION -->
        <div class="flow-section">
            <div class="section-header">
                <h2><i class="fas fa-random"></i> Transfer Order Flow Process</h2>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="flow-container">
                <div class="flow-diagram">

                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Transfer Order Created</span>
                                <span class="action-status status-pending">DRAFT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin creates a transfer order with source and destination warehouse details, and the items to be transferred.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Create Transfer Order</span>
                                <span class="action-status status-pending">DRAFT</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Create transfer order in Zoho Inventory</li>
                                    <li>Status: DRAFT</li>
                                    <li>Specify source and destination warehouse</li>
                                    <li>Add all items being moved</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>

                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Transfer Order Confirmed</span>
                                <span class="action-status status-pending">OPEN</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Admin confirms the transfer order to initiate the movement of goods.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Confirm Transfer Order</span>
                                <span class="action-status status-pending">OPEN</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Update the transfer order status from DRAFT to OPEN in Zoho Inventory to initiate dispatch.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>

                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Items Dispatched</span>
                                <span class="action-status status-pending">DISPATCHED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Items are packed and shipped from the source warehouse.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Dispatch Items</span>
                                <span class="action-status status-pending">DISPATCHED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <ul>
                                    <li>Click "Ship" or "Dispatch" to move items out of the source warehouse</li>
                                    <li>Track shipment if necessary</li>
                                </ul>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>

                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Items Received</span>
                                <span class="action-status status-pending">RECEIVED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Receiving warehouse confirms the receipt of transferred goods.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Mark as Received</span>
                                <span class="action-status status-pending">RECEIVED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Update Zoho transfer order to mark items as received at the destination warehouse.</p>
                            </div>
                        </div>
                        <div class="connector"></div>
                        <div class="connector-dot"></div>
                    </div>

                    <div class="flow-step">
                        <div class="admin-action">
                            <div class="action-header">
                                <span class="action-title">Transfer Order Closed</span>
                                <span class="action-status status-closed">COMPLETED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>All items received successfully and transfer process is completed.</p>
                            </div>
                        </div>
                        <div class="zoho-action">
                            <div class="action-header">
                                <span class="action-title">Close Transfer Order</span>
                                <span class="action-status status-closed">COMPLETED</span>
                            </div>
                            <button class="toggle-details">Details <i class="fas fa-chevron-down"></i></button>
                            <div class="action-details">
                                <p>Mark the transfer order as COMPLETED in Zoho Inventory after confirming receipt of all items.</p>
                            </div>
                        </div>
                    </div>

                    <div class="notes">
                        <div class="notes-title"><i class="fas fa-info-circle"></i> Transfer Order Notes</div>
                        <div class="notes-content">
                            <ul>
                                <li>Transfer Orders are used to move items between warehouses or locations internally</li>
                                <li>No sales or payment are involved in transfer orders</li>
                                <li>Inventory is updated only when the items are received at the destination</li>
                                <li>Tracking dispatch and receipt ensures accurate stock movement</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle section visibility
            const sectionHeaders = document.querySelectorAll('.section-header');
            sectionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const section = header.parentElement;
                    const container = header.nextElementSibling;
                    const icon = header.querySelector('i');
                    
                    header.classList.toggle('active');
                    container.classList.toggle('active');
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
            
            // Toggle action details
            const toggleButtons = document.querySelectorAll('.toggle-details');
            toggleButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const details = button.nextElementSibling;
                    const icon = button.querySelector('i');
                    
                    button.classList.toggle('active');
                    details.classList.toggle('show');
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
            
            // Open first section by default
            const firstSection = document.querySelector('.flow-section');
            if (firstSection) {
                const firstHeader = firstSection.querySelector('.section-header');
                const firstContainer = firstSection.querySelector('.flow-container');
                const firstIcon = firstSection.querySelector('.section-header i');
                
                firstHeader.classList.add('active');
                firstContainer.classList.add('active');
                firstIcon.classList.remove('fa-chevron-down');
                firstIcon.classList.add('fa-chevron-up');
            }
            
            // Tooltip functionality
            const tooltips = document.querySelectorAll('.tooltip');
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseenter', function() {
                    const tooltipText = this.querySelector('.tooltiptext');
                    tooltipText.style.visibility = 'visible';
                    tooltipText.style.opacity = '1';
                });
                
                tooltip.addEventListener('mouseleave', function() {
                    const tooltipText = this.querySelector('.tooltiptext');
                    tooltipText.style.visibility = 'hidden';
                    tooltipText.style.opacity = '0';
                });
            });
        });
    </script>
</body>
</html>