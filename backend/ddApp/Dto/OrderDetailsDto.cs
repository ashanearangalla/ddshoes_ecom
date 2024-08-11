using ddApp.Dto;

public class OrderDetailDto
{
    public int OrderID { get; set; }
    public DateTime OrderDate { get; set; }
    public string OrderStatus { get; set; }
    public List<OrderItemUserDto> OrderItems { get; set; }
}