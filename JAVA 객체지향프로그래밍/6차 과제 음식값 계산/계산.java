public class 계산{

    public int[] price = {5000, 6000, 15000, 7000, 7000, 0};
    public int 금액 = 0;

    public int 짜장면(int 그릇1) {
        price[5] = price[0] * 그릇1;
        금액 += price[5];
        return price[5];
    }

    public int 짬뽕(int 그릇2) {
        price[5] = price[1] * 그릇2;
        금액 += price[5];
        return price[5];
    }

    public int 탕수육(int 그릇3) {
        price[5] = price[2] * 그릇3;
        금액 += price[5];
        return price[5];
    }

    public int 볶음밥(int 그릇4) {
        price[5] = price[3] * 그릇4;
        금액 += price[5];
        return price[5];
    }

    public int 짜장밥(int 그릇5) {
        price[5] = price[4] * 그릇5;
        금액 += price[5];
        return price[5];
    }
}
