using AutoMapper;
using ddApp.Dto;
using ddApp.Models;

namespace ddApp.Helper
{
    public class MappingProfiles : Profile
    {
        public MappingProfiles() 
        {
            CreateMap<Product, ProductDto>().ReverseMap();
            CreateMap<Order, OrderDto>().ReverseMap();
            CreateMap<PreOrder, PreOrderDto>().ReverseMap();
            CreateMap<Outlet, OutletDto>().ReverseMap();
            CreateMap<Customer, CustomerDto>().ReverseMap();
            CreateMap<Sale, SaleDto>().ReverseMap();
            CreateMap<OrderItem, OrderItemDto>().ReverseMap();
            CreateMap<Partner, PartnerDto>().ReverseMap();
            CreateMap<SubStock, SubStockDto>().ReverseMap();
            CreateMap<MainStock, MainStockDto>().ReverseMap();
            CreateMap<User, UserDto>().ReverseMap();
        }
    }
}
