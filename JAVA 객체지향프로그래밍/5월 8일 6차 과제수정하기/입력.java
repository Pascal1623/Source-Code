import java.util.Scanner;

public class 입력 {
    Scanner sc = new Scanner(System.in);
    private int 그릇1;
    private int 그릇2;
    private int 그릇3;
    private int 그릇4;
    private int 그릇5;

    public void input(){
        System.out.print("짜장면을 몇 그릇 주문하시겠습니까? : ");
        그릇1 = sc.nextInt();

        System.out.print("짬뽕을 몇 그릇 주문하시겠습니까? : ");
        그릇2 = sc.nextInt();

        System.out.print("탕수육을 몇 그릇 주문하시겠습니까? : ");
        그릇3 = sc.nextInt();

        System.out.print("볶음밥을 몇 그릇 주문하시겠습니까? : ");
        그릇4 = sc.nextInt();

        System.out.print("짜장밥을 몇 그릇 주문하시겠습니까? : ");
        그릇5 = sc.nextInt();
    }

    public int get그릇1() {
        return 그릇1;
    }

    public int get그릇2() {
        return 그릇2;
    }

    public int get그릇3() {
        return 그릇3;
    }

    public int get그릇4() {
        return 그릇4;
    }

    public int get그릇5() {
        return 그릇5;
    }
}
