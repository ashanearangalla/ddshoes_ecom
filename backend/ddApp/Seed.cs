using ddApp.DAL;
using ddApp.Models;

namespace ddApp
{
    public class Seed
    {
        private readonly DataContext dataContext;

        public Seed(DataContext context)
        {
            this.dataContext = context;
        }

        public void SeedDataContext()
        {
            if (!dataContext.Products.Any())
            {
                // Add users
                var users = new User[]
                {
                    new User
                    {
                        Username = "colombo_outlet",
                        Password = "password", // Hash the password in a real application
                        Role = "OutletManager"
                    },
                    new User
                    {
                        Username = "kandy_outlet",
                        Password = "password", // Hash the password in a real application
                        Role = "OutletManager"
                    },
                    new User
                    {
                        Username = "partner1",
                        Password = "password", // Hash the password in a real application
                        Role = "Partner"
                    },
                    new User
                    {
                        Username = "partner2",
                        Password = "password", // Hash the password in a real application
                        Role = "Partner"
                    }
                };
                dataContext.Users.AddRange(users);
                dataContext.SaveChanges();

                // Add outlets
                var outlets = new Outlet[]
                {
                    new Outlet
                    {
                        OutletName = "Colombo Outlet",
                        Location = "Colombo",
                        UserID = users[0].UserID
                    },
                    new Outlet
                    {
                        OutletName = "Kandy Outlet",
                        Location = "Kandy",
                        UserID = users[1].UserID
                    }
                };
                dataContext.Outlets.AddRange(outlets);
                dataContext.SaveChanges();

                // Add partners
                var partners = new Partner[]
                {
                    new Partner
                    {
                        PartnerName = "Partner 1",
                        ContactEmail = "partner1@gmail.com",
                        ContactPhone = "0771234567",
                        UserID = users[2].UserID
                    },
                    new Partner
                    {
                        PartnerName = "Partner 2",
                        ContactEmail = "partner2@gmail.com",
                        ContactPhone = "0777654321",
                        UserID = users[3].UserID
                    }
                };
                dataContext.Partners.AddRange(partners);
                dataContext.SaveChanges();

                // Add products
                var products = new Product[]
                {
                    new Product
                    {
                        ProductName = "Running Shoes",
                        Description = "High-quality running shoes",
                        Price = 7500m,
                        IsLocked = false,
                        ImageUrl = "images/running_shoes.jpg" // Image path
                    },
                    new Product
                    {
                        ProductName = "Formal Shoes",
                        Description = "Elegant formal shoes for men",
                        Price = 9500m,
                        IsLocked = false,
                        ImageUrl = "images/formal_shoes.jpg" // Image path
                    }
                };
                dataContext.Products.AddRange(products);
                dataContext.SaveChanges();

                // Add customers
                var customers = new Customer[]
                {
                    new Customer
                    {
                        CustomerName = "Namal Rajapaksha",
                        Email = "namal@gmail.com",
                        Phone = "0776392210"
                    },
                    new Customer
                    {
                        CustomerName = "Ranil Wickremasinghe",
                        Email = "ranil@gmail.com",
                        Phone = "0776821211"
                    }
                };
                dataContext.Customers.AddRange(customers);
                dataContext.SaveChanges();

                // Add orders
                var orders = new Order[]
                {
                    new Order
                    {
                        CustomerID = customers[0].CustomerID,
                        OrderDate = DateTime.Now,
                        OrderStatus = "Processing"
                    },
                    new Order
                    {
                        CustomerID = customers[1].CustomerID,
                        OrderDate = DateTime.Now,
                        OrderStatus = "Processing"
                    }
                };
                dataContext.Orders.AddRange(orders);
                dataContext.SaveChanges();

                // Add order items
                var orderItems = new OrderItem[]
                {
                    new OrderItem
                    {
                        OrderID = orders[0].OrderID,
                        ProductID = products[0].ProductID,
                        Quantity = 1
                    },
                    new OrderItem
                    {
                        OrderID = orders[1].OrderID,
                        ProductID = products[1].ProductID,
                        Quantity = 2
                    }
                };
                dataContext.OrderItems.AddRange(orderItems);
                dataContext.SaveChanges();

                // Add main stock
                var mainStocks = new MainStock[]
                {
                    new MainStock
                    {
                        ProductID = products[0].ProductID,
                        Quantity = 200,
                        Sold = 50
                    },
                    new MainStock
                    {
                        ProductID = products[1].ProductID,
                        Quantity = 150,
                        Sold = 30
                    }
                };
                dataContext.MainStocks.AddRange(mainStocks);
                dataContext.SaveChanges();

                // Add sub-stock details for outlets
                var subStocks = new SubStock[]
                {
                    new SubStock
                    {
                        ProductID = products[0].ProductID,
                        UserID = users[0].UserID,
                        Quantity = 100,
                        Sold = 20
                    },
                    new SubStock
                    {
                        ProductID = products[1].ProductID,
                        UserID = users[1].UserID,
                        Quantity = 50,
                        Sold = 10
                    }
                };
                dataContext.SubStocks.AddRange(subStocks);
                dataContext.SaveChanges();

                // Add pre-orders
                var preOrders = new PreOrder[]
                {
                    new PreOrder
                    {
                        ProductID = products[0].ProductID,
                        CustomerID = customers[0].CustomerID,
                        Quantity = 1,
                        PreOrderDate = DateTime.Now,
                        IsFulfilled = false
                    },
                    new PreOrder
                    {
                        ProductID = products[1].ProductID,
                        CustomerID = customers[1].CustomerID,
                        Quantity = 2,
                        PreOrderDate = DateTime.Now,
                        IsFulfilled = false
                    }
                };
                dataContext.PreOrders.AddRange(preOrders);
                dataContext.SaveChanges();

                // Add sales
                var sales = new Sale[]
                {
                    new Sale
                    {
                        SubStockID = subStocks[0].SubStockID,
                        Quantity = 1,
                        SaleDate = DateTime.Now
                    },
                    new Sale
                    {
                        SubStockID = subStocks[1].SubStockID,
                        Quantity = 2,
                        SaleDate = DateTime.Now
                    }
                };
                dataContext.Sales.AddRange(sales);
                dataContext.SaveChanges();
            }
        }
    }
}
