//10������ 2������ ��ȯ�ϴ� ���α׷�
#include <stdio.h>
int main(void)
{
	int flag = 0x80;
	int num, i;

	printf("10������ �Է��ϼ���.:");
	scanf("%d", &num);

	for (i = 7; i >= 0; i--)
	{
		printf("%d", (num&flag) >> i);
		flag = flag >> 1;
	}

	return 0;
}